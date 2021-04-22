<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order\Order;
use App\Models\Order\OrderDetail;

class InvoiceController extends Controller
{

    public function index(Request $request) {
        $orders = Order::with('orderDetails')->latest()->paginate(10);

        return view('invoice.index', compact('orders'));
    }

    public function show(Request $request, Order $order) {
        $invoice = Order::with('user', 'orderDetails.product')
            ->where('id', $order->id)
            ->first();

        $statuses = [
            'waiting',
            'process',
            'done',
            'denied'
        ];

        return view('invoice.show', compact('invoice', 'statuses'));
    }

    public function update(Request $request, Order $order) {
        $order->status = $request->status;
        $order->save();

        return redirect('invoices')->withSuccess('Success');
    }

}
