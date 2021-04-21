<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Product\ProductType;
use Illuminate\Http\Request;
use Str;
use Image;

class ProductController extends Controller
{
    protected $uploadPath;

    public function __construct() {
        $this->uploadPath = public_path('uploads/products/');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::with('productType')->when($request->search, function($query) use ($request) {
            $search = $request->search;
            return $query->where('name', 'like', "%$search%")
                ->orWhere('price', 'like', "%$search%");
        })->latest()->paginate(10);

        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductType::all()->pluck('name', 'id');

        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->product_type_id = $request->product_type_id;

        if($request->hasFile('image')) {

            if(!file_exists($this->uploadPath)) {
                mkdir($this->uploadPath, 777, true);
            }

            $image = $request->image;
            $ext = $request->image->getClientOriginalExtension();
            $imageName = Str::uuid() . '.' . $ext;
            $thumbnail = Image::make($image->getRealPath())->resize(1024, 512);
            $savedImage = Image::make($thumbnail)->save($this->uploadPath . $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return redirect('products')->withSuccess('Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = ProductType::all()->pluck('name', 'id');

        return view('product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'product_type_id' => $request->product_type_id,
        ]);

        if($request->hasFile('image')) {

            if(!file_exists($this->uploadPath)) {
                mkdir($this->uploadPath, 777, true);
            }

            $image = $request->image;
            $ext = $request->image->getClientOriginalExtension();
            $imageName = Str::uuid() . '.' . $ext;
            $thumbnail = Image::make($image->getRealPath())->resize(1024, 1024);
            $savedImage = Image::make($thumbnail)->save($this->uploadPath . $imageName);

            if($product->image !== null) {
                unlink($this->uploadPath . $product->image);
            }

            $product->update([
                'image' => $imageName
            ]);
        }

        return redirect('products')->withSuccess('Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->image !== null) {
            unlink($this->uploadPath . $product->image);
        }
        $product->delete();

        return redirect(url()->previous());
    }
}
