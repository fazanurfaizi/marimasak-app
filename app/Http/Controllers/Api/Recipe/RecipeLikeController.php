<?php

namespace App\Http\Controllers\Api\Recipe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe\Recipe;
use App\Models\Recipe\RecipeLike;
use Auth;

class RecipeLikeController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $recipe = Recipe::where('id', $id)->first();

        if(!$recipe) {
            return response()->json([
                'Recipe not found'
            ], 404);
        }

        if($recipe->isLiked()) {
            $recipe->dislike();

            return response()->json([
                'Recipe disliked'
            ]);
        } else {
            $recipe->like($request->type);

            return response()->json([
                'Recipe liked'
            ]);
        }
    }
}
