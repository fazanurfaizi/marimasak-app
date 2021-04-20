<?php

namespace App\Http\Controllers\Api\User;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()->orderBy('updated_at', 'desc');

        return response()->json([
            'data' => $users
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
        $user = User::with(['recipes', 'followers', 'followings'])
            ->where('id', $id)
            ->first();

        if(!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'data' => $user
        ]);
    }

    public function follow(Request $request) {
        $user = User::find($request->user_id);
        $response = Auth::user()->toggleFollow($user);

        return response()->json([
            'data' => $response
        ]);
    }

}
