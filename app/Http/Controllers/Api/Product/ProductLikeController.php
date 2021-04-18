<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\ProductLike;
use Auth;

class ProductLikeController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();

        if(!$product) {
            return response()->json([
                'Product not found'
            ], 404);
        }

        if($product->isLiked()) {
            $product->dislike();

            return response()->json([
                'Product disliked'
            ]);
        } else {
            $product->like($request->type);

            return response()->json([
                'Product liked'
            ]);
        }
    }
}
