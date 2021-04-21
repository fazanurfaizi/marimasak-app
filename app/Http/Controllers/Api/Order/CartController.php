<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Order\Cart;
use App\Models\Order\CartItem;
use App\Models\Order\Order;
use App\Models\Order\OrderDetail;
use App\Models\Product\Product;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::with('cartItems.product')
            ->where('user_id', Auth::user()->id)
            ->first();

        return response()->json([
            'data' => $cart
        ]);
    }


    public function addProducts(Request $request) {
        $cart = Auth::user()->cart;

        try {
            $product = Product::findOrFail($request->product_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'The Product you\'re trying to add does not exist.',
            ], 404);
        }

        $cartItem = CartItem::where([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id
        ])->first();

        if($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->price = $request->quantity * $product->price;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->quantity * $product->price
            ]);
        }

        return response()->json([
            'message' => 'The Cart was updated with the given product information successfully'
        ], 200);
    }

    public function removeProduct(Request $request) {
        $cart = Auth::user()->cart;

        try {
            $product = Product::findOrFail($request->product_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'The Product you\'re trying to add does not exist.',
            ], 404);
        }

        $cartItem = CartItem::where([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id
        ])->first();

        if($cartItem) {
            $cartItem->delete();
        }

        return response()->json([
            'message' => 'The Cart was updated with the given product information successfully'
        ], 200);
    }

    public function checkout(Request $request) {
        $cart = Auth::user()->cart;

        $totalPrice = (float) 0.0;
        $items = $cart->cartItems;

        foreach ($items as $item) {
            $product = Product::find($item->product_id);
            $price = $product->price;
            $totalPrice  = $totalPrice + ($price * $item->quantity);
        }

        if(count($items) > 0) {
            $todayItem = Order::count();
            $numberItem = ($todayItem + 1) > 9 ? $todayItem + 1 : '0'.($todayItem + 1);
            $latest = Order::latest()->first();

            $invoice_number = 'INV-'.$numberItem.str_pad($latest ? $latest->id : 0 + 1, 3, "0", STR_PAD_LEFT);

            $order = Order::create([
                'user_id' => Auth::user()->id,
                'promo_id' => 1,
                'invoice_number' => $invoice_number,
                'total' => $totalPrice,
                'status' => Order::WAITING
            ]);
        } else {
            return response()->json([
                'message' => 'you have no item on the cart',
            ], 401);
        }

        foreach ($items as $item) {
            $product = Product::find($item->product_id);
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $product->price,
            ]);
            $item->delete();
        }

        return response()->json([
            'message' => 'you\'re order has been completed succefully, thanks for shopping with us!',
        ], 200);
    }
}
