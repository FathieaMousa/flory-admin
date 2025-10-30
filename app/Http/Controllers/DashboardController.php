<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
public function index(\Illuminate\Http\Request $request)
{
    $filter = $request->get('filter', 'month'); // default

    $query = \App\Models\Order::query();
    $now = now();

    if ($filter === 'month') {
        $query->whereMonth('created_at', $now->month);
    } elseif ($filter === '3months') {
        $query->whereBetween('created_at', [$now->subMonths(3), now()]);
    } elseif ($filter === '6months') {
        $query->whereBetween('created_at', [$now->subMonths(6), now()]);
    } elseif ($filter === 'year') {
        $query->whereYear('created_at', $now->year);
    }

    $monthlySales = $query->selectRaw('MONTH(created_at) as month, SUM(total) as total')
        ->groupBy('month')->orderBy('month')->pluck('total', 'month')->toArray();

    if ($request->ajax()) {
        $labels = array_map(fn($m) => date('M', mktime(0, 0, 0, $m, 1)), array_keys($monthlySales));
        return response()->json(['labels' => $labels, 'sales' => array_values($monthlySales)]);
    }

    $stats = [
        'products'  => \App\Models\Product::count(),
        'orders'    => \App\Models\Order::count(),
        'customers' => \App\Models\Customer::count(),
        'sales'     => \App\Models\Order::sum('total'),
        'notifications' => \App\Models\Notification::count(),
    ];

    $topProducts = \App\Models\OrderItem::select('product_id', DB::raw('SUM(qty) as total_qty'))
        ->groupBy('product_id')->orderByDesc('total_qty')->take(5)->with('product')->get();

    $latestOrders = \App\Models\Order::with('customer')->latest()->take(5)->get();

    return view('admin.dashboard.index', compact('stats', 'monthlySales', 'topProducts', 'latestOrders'));
}

}
