<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function dashboard()
{
    // Calculate profits
    $todayProfit = Order::whereDate('created_at', Carbon::today())->sum('price');
    $thisMonthProfit = Order::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('price');
    $lastMonthProfit = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)->whereYear('created_at', Carbon::now()->subMonth()->year)->sum('price');
    $lastFourMonthsProfit = Order::whereBetween('created_at', [Carbon::now()->subMonths(4), Carbon::now()])->sum('price');
    $thisYearProfit = Order::whereYear('created_at', Carbon::now()->year)->sum('price');
    $lastYearProfit = Order::whereYear('created_at', Carbon::now()->subYear()->year)->sum('price');

    // Fetch other data
    $totalOrders = Order::count();
    $totalProducts = Product::count();
    $recentOrders = Order::latest()->take(5)->get();
    $topProducts = Product::with('orderItems')
                    ->get()
                    ->mapWithKeys(function ($product) {
                        return [$product->name => $product->orderItems->sum('quantity')];
                    })
                    ->sortDesc()
                    ->take(5);
                    
    return view('backend.dashboard', compact('todayProfit', 'thisMonthProfit', 'lastMonthProfit', 'lastFourMonthsProfit', 'thisYearProfit', 'lastYearProfit', 'totalOrders', 'totalProducts', 'recentOrders', 'topProducts'));
}

}
