<?php

namespace App\Http\Controllers\Api\Chat;

use Str;
use Auth;
use App\Models\Chat\Chatroom;
use App\Events\Chat\RoomCreated;
use App\Events\Chat\RoomUpdated;
use App\Events\Chat\RoomDeleted;
use App\Events\Chat\RoomTyping;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $rooms = $user->members;

        foreach ($rooms as $key => $value) {
            $room = Chatroom::find($value->id);
            $value->users = $room->users;
            $value->messages = $room->messages;
        }

        return response()->json([
            'data' => $rooms
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $room = new Room();
        $room->name = (string) Str::uuid();

        $user->chatrooms()->save($room);

        $room->users()->attach($user->id);
        $room->users()->attach($request->friend_id);

        broadcast(new RoomCreated($user, $room));

        return response()->json([
            'message' => 'Chatroom created successfully',
            'data' => $room
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Chatroom::with('messages')->where('id', $id)->first();
        if(!$room) {
            return response()->json([
                'message' => 'Chatroom not found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Chatroom::find($id);
        if(!$room || $room->owner->id !== Auth::user()->id) {
            return response()->json([
                'message' => 'Chatroom failed to delete',
                'status' => false
            ], 403);
        }

        broadcast(new RoomDeleted($room));

        $room->users()->detach();

        $room->messages->map(
            function($message, $key) {
                if($message->filename) {
                    unlink(public_path('/chat/').$message->filename);
                }
            }
        );

        $room->messages()->delete();
        $room->delete();

        return response()->json([
            'message' => 'Chatroom deleted successfully',
            'status' => true
        ]);
    }

    /**
     * Set Typing indicator in chat room
     *
     * @param   $id
     * @return  \Illuminate\Http\Response
     */
    public function typing($id) {
        $room = Chatroom::find($id);
        if(!$room) {
            return response()->json([
                'message' => 'Chatroom not found'
            ], 404);
        }
        // get current user and send 'typing' broadcast
        $user = Auth::user();
        broadcast(new RoomTyping($user, $room));

        return response([
            'data' => $room,
            'status' => true
        ]);
    }

    /**
     * Set reading progress of a user in a room
     *
     * @param   $id
     * @return  \Illuminate\Http\Response
     */
    public function setReading($id) {
        $room = Chatroom::find($id);
        if(!$room) {
            return response()->json([
                'message' => 'Chatroom not found'
            ], 404);
        }

        // Get current user
        $user = Auth::user();

        // set the updated_at date in the pivot table
        // to indicated the reading progress of the user in this room
        $members = $room->users()->where('user_id', $user->id)->first();
        $members->pivot->touch();

        // inform all subscribers of this change
        broadcast(new RoomUpdated($user, $room));

        return response()->json([
            'data' => $room,
            'status' => true
        ]);
    }


}
