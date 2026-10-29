<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $userId = auth()->id();
        $baseQuery = Order::where('user_id', $userId);

        $query = (clone $baseQuery)->with('items');

        if ($request->filled('search')) {
            $term = trim($request->input('search'));
            $query->where(function ($q) use ($term) {
                $q->where('order_number', 'like', "%{$term}%")
                  ->orWhere('customer_name', 'like', "%{$term}%")
                  ->orWhere('customer_email', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('order_status', $request->input('status'));
        }

        if ($request->filled('source') && $request->input('source') !== 'All') {
            $query->where('source', $request->input('source'));
        }

        if ($request->filled('payment_status') && $request->input('payment_status') !== 'All') {
            $query->where('payment_status', $request->input('payment_status'));
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        $totalOrders = (clone $baseQuery)->count();
        $completedOrders = (clone $baseQuery)->where('order_status', 'Completed')->count();
        $processingOrders = (clone $baseQuery)->where('order_status', 'Processing')->count();
        $pendingOrders = (clone $baseQuery)->where('order_status', 'Pending')->count();
        $totalSales = (clone $baseQuery)->where('payment_status', 'Paid')->sum('total_amount');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $orders,
            ]);
        }

        return view('orders.index', compact(
            'orders',
            'totalOrders',
            'completedOrders',
            'processingOrders',
            'pendingOrders',
            'totalSales'
        ));
    }

    public function show(Order $order, Request $request): View|JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
            }
            abort(404);
        }

        $order->load('items');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'order' => $order,
            ]);
        }

        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse|JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
            }
            abort(404);
        }

        $validated = $request->validate([
            'order_status' => 'required|in:Pending,Processing,Completed,Cancelled',
            'payment_status' => 'nullable|in:Paid,Pending,Refunded',
        ]);

        $order->update($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Order #{$order->order_number} status updated to {$order->order_status}.",
                'order' => $order,
            ]);
        }

        return redirect()->route('orders.index')->with('success', "Order #{$order->order_number} status updated.");
    }

    public function destroy(Order $order): RedirectResponse
    {
        if ($order->user_id !== auth()->id()) {
            abort(404);
        }

        $orderNum = $order->order_number;
        $order->delete();

        return redirect()->route('orders.index')->with('success', "Order #{$orderNum} has been deleted.");
    }
}
