<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\User\User;

class DashboardController extends Controller
{

    public function index() {
        return view('dashboard', [
            'total_orders' => Order::count(),
            'total_products' => Product::count(),
            'total_users' => User::count()
        ]);
    }

}
