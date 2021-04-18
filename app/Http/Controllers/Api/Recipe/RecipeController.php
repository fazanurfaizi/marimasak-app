<?php

namespace App\Http\Controllers\Api\Recipe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe\Recipe;
use Auth;
use Image;

class RecipeController extends Controller
{
    protected $uploadPath;

    public function __construct() {
        $this->middleware('auth:api', ['except' => [
            'index', 'show'
        ]]);

        $this->uploadPath = public_path('uploads/recipes/');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $recipes = Recipe::orderBy('created_at', 'DESC')
            ->limit($request->get('limit'))
            ->get();

        return response()->json([
            'data' => $recipes
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
        $recipe = new Recipe();
        $recipe->name = $request->name;
        $recipe->description = $request->description;
        $recipe->materials = $request->materials;
        $recipe->methods = $request->methods;
        $recipe->user_id = Auth::user()->id;

        if($request->hasFile('thumbnail')) {

            if(!file_exists($this->uploadPath)) {
                mkdir($this->uploadPath, 777, true);
            }

            $image = $request->thumbnail;
            $ext = $request->thumbnail->getClientOriginalExtension();
            $imageName = date('YmdHis') . rand(1, 999999) . '.' . $ext;
            $thumbnail = Image::make($image->getRealPath())->resize(1024, 512);
            $savedImage = Image::make($thumbnail)->save($this->uploadPath . $imageName);
            $recipe->image = $imageName;
        }

        $recipe->save();

        return response()->json([
            'message' => 'Recipe succesffulyy added',
            'data' => $recipe
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
        $recipe = Recipe::with([
            'user',
            'comments',
            'likes',
        ])->where('id', $id)->first();

        if(!$recipe) {
            return response()->json([
                'message' => 'Recipe not found'
            ], 404);
        }

        return response()->json([
            'data' => $recipe
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
        $recipe = Recipe::findOrFail($id);

        $recipe->name = $request->name;
        $recipe->description = $request->description;
        $recipe->materials = $request->materials;
        $recipe->methods = $request->methods;
        $recipe->save();

        return response()->json([
            'message' => 'Recipe succesffulyy updated',
            'data' => $recipe
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
        $recipe = Recipe::where('id', $id)->first();
        if($recipe) {
            Recipe::findOrFail($id)->delete();
        } else {
            return response()->json([
                'message' => 'Recipe not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Recipe succesffulyy deleted',
            'data' => $recipe
        ]);
    }
}
