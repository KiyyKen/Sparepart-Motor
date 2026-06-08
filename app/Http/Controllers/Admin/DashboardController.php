<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'categoryCount' => Category::count(),
            'orderCount' => Order::count(),
            'customerCount' => User::where('role', 'customer')->count(),
            'latestOrders' => Order::with('user')->latest()->take(5)->get(),
        ]);
    }
}
