<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product\ProductType;

class ProductTypeController extends Controller
{

    public function __invoke() {
        $types = ProductType::with('products')->get();

        return response()->json([
            'data' => $types
        ]);
    }

}
