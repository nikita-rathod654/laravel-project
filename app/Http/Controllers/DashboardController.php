<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\Vendor;
use App\Models\Promotion;
use App\Models\MarketingCampaign;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $totalRevenue = Order::where('user_id', $userId)->where('payment_status', 'Paid')->sum('total_amount');
        $totalOrders = Order::where('user_id', $userId)->count();
        $completedOrders = Order::where('user_id', $userId)->where('order_status', 'Completed')->count();
        $pendingOrders = Order::where('user_id', $userId)->where('order_status', 'Pending')->count();

        $totalProducts = Product::where('user_id', $userId)->count();
        $activeProducts = Product::where('user_id', $userId)->where('status', 'Active')->count();
        $lowStockProducts = Product::where('user_id', $userId)->where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', 15)
            ->count();
        $outOfStock = Product::where('user_id', $userId)->where('stock_quantity', '<=', 0)->count();

        $totalStores = Store::where('user_id', $userId)->count();
        $activeStores = Store::where('user_id', $userId)->where('status', 'Active')->count();

        $totalVendors = Vendor::where('user_id', $userId)->count();
        $activePromotions = Promotion::where('user_id', $userId)->where('status', 'Active')->count();
        $activeCampaigns = MarketingCampaign::where('user_id', $userId)->where('status', 'Active')->count();

        // Recent Orders with relations
        $recentOrders = Order::where('user_id', $userId)->with('items')
            ->latest()
            ->take(6)
            ->get();

        // Low stock products alert
        $criticalInventory = Product::where('user_id', $userId)->where('stock_quantity', '<=', 20)
            ->orderBy('stock_quantity', 'asc')
            ->take(5)
            ->get();

        // Top products by price or stock
        $featuredProducts = Product::where('user_id', $userId)->where('status', 'Active')
            ->orderBy('price', 'desc')
            ->take(4)
            ->get();

        // 7-day sales trend mock data based on recent orders
        $weeklySales = [
            ['day' => 'Mon', 'amount' => 1240, 'orders' => 14],
            ['day' => 'Tue', 'amount' => 1890, 'orders' => 19],
            ['day' => 'Wed', 'amount' => 2450, 'orders' => 28],
            ['day' => 'Thu', 'amount' => 2100, 'orders' => 22],
            ['day' => 'Fri', 'amount' => 3480, 'orders' => 36],
            ['day' => 'Sat', 'amount' => 4120, 'orders' => 45],
            ['day' => 'Sun', 'amount' => 2980, 'orders' => 31],
        ];

        return view('dashboard.index', compact(
            'totalRevenue',
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'outOfStock',
            'totalStores',
            'activeStores',
            'totalVendors',
            'activePromotions',
            'activeCampaigns',
            'recentOrders',
            'criticalInventory',
            'featuredProducts',
            'weeklySales'
        ));
    }
}
