<?php

namespace App\Http\Controllers\Api\Chat;

use Auth;
use Log;
use File;
use Str;
use App\Models\Chat\Message;
use App\Models\Chat\Chatroom;
use App\Events\Chat\RoomUpdated;
use App\Events\Chat\MessagePosted;
use App\Events\Chat\MessageUpdated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function index() {
        return response()->json([
            'data' => Message::with('user')->get()
        ]);
    }

    public function store(Request $request) {
        $user = Auth::user();

        // Check if we have a message and if the user is member of this room
        if(strlen($request->message) && $user->isMemberOf($request->chatroom_id)) {
            $message = new Message([
                'body' => $request->message,
                'user_id' => $user->id
            ]);

            $chatroom = ChatRoom::find($request->chatroom_id);
            if(!$chatroom) {
                return response()->json([
                    'message' => 'Chat Room not found'
                ], 404);
            }

            $chatroom->messages()->save($message);

            $members = $user->members()->where('chatroom_id')->first();
            $members->pivot->touch();

            broadcast(new RoomUpdated($user, $chatroom));
            broadcast(new MessagePosted($user, $message));

            return response()->json([
                'message' => 'Message sent successfully',
                'status' => true
            ]);
        }

        return response()->json([
            'message' => 'Message failed to send',
            'status' => false
        ], 403);

    }

    public function upload(Request $request, Chatroom $room) {
        $user = Auth::user();

        if($user->isMemberOf($room->id) && $request->file('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $exention = $image->getClientOriginalExtension();
            $outputName = Str::uuid() . $filename;

            switch ($extension) {
                case 'mp3':
                    $type = 'audio';
                    break;
                case 'aac':
                    $type = 'audio';
                    break;
                case 'amr':
                    $type = 'audio';
                    break;
                case 'mp4':
                    $type = 'video';
                    break;
                case 'png':
                    $type = 'image';
                    break;
                case 'gif':
                    $type = 'image';
                    break;
                case 'jpg':
                    $type = 'image';
                    break;
                case 'jpeg':
                    $type = 'image';
                    break;
                default:
                    $type = explode('/', $image->getMimeType())[0];
            }

            if(!$type) $type = 'audio';

            $file->move(public_path('/chat/'), $outputName);

            $message = new Message([
                'body' => $filename,
                'filename' => $outputName,
                'filetype' => $type,
                'user_id' => $user->id
            ]);

            $room->messages()->save($members);

            $members = $user->members()->where('chatroom_id', $room->id)->first();
            $members->pivot->touch();

            broadcast(new RoomUpdated($user, $room));
            broadcast(new MessagePosted($user, $message));

            return response()->json([
                'message' => 'File sent successfully',
                'file' => $outputName,
                'status' => true
            ]);
        }

        return response()->json([
            'messsage' => 'Message failed to sent',
            'status' => false
        ], 403);
    }

    public function destroy($id) {
        $message = Message::find($id);
        $user = Auth::user();

        if($user->id === $message->user_id) {
            if($message->filename) {
                // Delete file
                unlink(public_path('/chat/'.$message->filename));
            }

            $message->update([
                'message' => $message->updated_at,
                'filename' => null,
                'filetype' => null
            ]);

            broadcast(new MessageUpdated($user, $message));

            return response()->json([
                'message' => 'Message deleted successfully',
                'status' => true
            ]);
        }

        return response()->json([
            'message' => 'Message failed to delete',
            'status' => false
        ], 403);
    }

}
