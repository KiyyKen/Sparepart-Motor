<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $since = now()->subDays(13)->startOfDay();

        $dailyRevenue = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $since)
            ->get(['created_at', 'total_amount'])
            ->groupBy(fn ($order) => $order->created_at->format('Y-m-d'))
            ->map(fn ($orders) => $orders->sum('total_amount'));

        $salesChart = collect(range(0, 13))->map(function ($i) use ($since, $dailyRevenue) {
            $date = $since->copy()->addDays($i);

            return [
                'label' => $date->translatedFormat('d M'),
                'total' => (int) ($dailyRevenue[$date->format('Y-m-d')] ?? 0),
            ];
        });

        $topProducts = OrderItem::query()
            ->selectRaw('product_name, SUM(quantity) as total_qty')
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        $statusCounts = Order::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'categoryCount' => Category::count(),
            'orderCount' => Order::count(),
            'customerCount' => User::where('role', 'customer')->count(),
            'revenueTotal' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'latestOrders' => Order::with('user')->latest()->take(5)->get(),
            'salesChart' => $salesChart,
            'topProducts' => $topProducts,
            'statusCounts' => $statusCounts,
        ]);
    }
}
