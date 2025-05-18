<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function getTopSellingProducts()
    {
        $topProducts = OrderItem::select('book_id', DB::raw('SUM(quantity) as total_sold'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->with('book:id,title')
            ->groupBy('book_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return response()->json([
            'labels' => $topProducts->pluck('book.title'),
            'values' => $topProducts->pluck('total_sold')
        ]);
    }

    public function getOrderStatus()
    {
        $orderStatus = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $statusLabels = [
            'pending' => 'Pending',
            'shipping' => 'Shipping',
            'delivering' => 'Delivering',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'returned' => 'Returned'
        ];

        $labels = [];
        $values = [];
        $colors = [
            'rgba(255, 159, 64, 0.8)',  // Orange for Pending
            'rgba(54, 162, 235, 0.8)',  // Blue for Shipping
            'rgba(75, 192, 192, 0.8)',  // Teal for Delivering
            'rgba(75, 192, 75, 0.8)',   // Green for Completed
            'rgba(255, 99, 132, 0.8)',  // Red for Cancelled
            'rgba(153, 102, 255, 0.8)'  // Purple for Returned
        ];

        foreach ($statusLabels as $key => $label) {
            $count = $orderStatus->firstWhere('status', $key)?->total ?? 0;
            if ($count > 0) {  // Only include statuses that have orders
                $labels[] = $label;
                $values[] = $count;
            }
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values,
            'colors' => array_slice($colors, 0, count($labels))  // Only include colors for active statuses
        ]);
    }
} 