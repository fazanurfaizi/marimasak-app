<?php

namespace App\Http\Controllers\Api\Product;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\ProductComment;
use App\Requests\Api\Product\StoreProductCommentRequest;
use App\Requests\Api\Product\UpdateProductCommentRequest;

class ProductCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductCommentRequest $request)
    {
        $comment = ProductComment::create([
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id
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
        $comment = ProductComment::with('user')
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
    public function update(UpdateProductCommentRequest $request, $id)
    {
        $comment = ProductComment::findOrFail($id);

        $comment->body = $request->body;
        $comment->product_id = $request->product_id;
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
        $comment = ProductComment::where('id', $id)->first();
        if($comment) {
            ProductComment::findOrFail($id)->delete();
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
