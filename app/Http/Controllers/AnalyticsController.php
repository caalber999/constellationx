<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use Carbon\Carbon;
use DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Productos más vendidos
        $topProducts = Product::select('products.name', DB::raw('COUNT(purchases.id) as count'))
            ->join('purchases', 'products.id', '=', 'purchases.product_id')
            ->groupBy('products.id', 'products.name')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        // Productos menos comprados
        $bottomProducts = Product::select('products.name', DB::raw('COUNT(purchases.id) as count'))
            ->leftJoin('purchases', 'products.id', '=', 'purchases.product_id')
            ->groupBy('products.id', 'products.name')
            ->orderBy('count', 'asc')
            ->limit(5)
            ->get();
        
        // Ingresos por día, semana y mes
        $dailyRevenue = Purchase::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        $weeklyRevenue = Purchase::select(DB::raw('WEEK(created_at) as week'), DB::raw('YEAR(created_at) as year'), DB::raw('SUM(amount) as total'))
            ->groupBy('week', 'year')
            ->orderBy('year', 'desc')
            ->orderBy('week', 'desc')
            ->limit(12)
            ->get();

        $monthlyRevenue = Purchase::select(DB::raw('MONTH(created_at) as month'), DB::raw('YEAR(created_at) as year'), DB::raw('SUM(amount) as total'))
            ->groupBy('month', 'year')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        return view('analytics.index', compact('topProducts', 'bottomProducts', 'dailyRevenue', 'weeklyRevenue', 'monthlyRevenue'));
    }
}
