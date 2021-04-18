<?php

namespace App\Http\Controllers\Api\Recipe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe\Recipe;
use App\Models\Recipe\RecipeComment;
use Auth;

class RecipeCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = RecipeComment::create([
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            'recipe_id' => $request->recipe_id
        ]);

        return response()->json([
            'message' => 'Comment succesffulyy added',
            'data' => $comment
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
        $comment = RecipeComment::with('user')
            ->where('id', $id)
            ->first();

        if(!$comment) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }

        return response()->json([
            'data' => $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = RecipeComment::findOrFail($id);

        $comment->body = $request->body;
        $comment->save();

        return response()->json([
            'message' => 'Comment succesffulyy updated',
            'data' => $comment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = RecipeComment::where('id', $id)->first();
        if($comment) {
            RecipeComment::findOrFail($id)->delete();
        } else {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Comment succesffulyy deleted',
            'data' => $comment
        ]);
    }
}
