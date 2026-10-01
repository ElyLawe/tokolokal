<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;

class KasirController extends Controller
{
    /**
     * Dashboard kasir.
     */
    public function dashboard()
    {
        $today = now()->toDateString();

        // Jumlah transaksi hari ini
        $todayTransactions = Transaction::whereDate(
            'created_at',
            $today
        )
        ->where('status', 'completed')
        ->count();


        // Total penjualan hari ini
        $todaySales = Transaction::whereDate(
            'created_at',
            $today
        )
        ->where('status', 'completed')
        ->sum('grand_total');


        // Jumlah barang yang masih aktif
        $totalProducts = Product::where(
            'is_active',
            true
        )->count();


        // Produk dengan stok menipis
        $lowStockProducts = Product::where(
            'is_active',
            true
        )
        ->where('stock', '<=', 5)
        ->orderBy('stock')
        ->get();


        // Transaksi terbaru
        $latestTransactions = Transaction::with('user')
            ->latest()
            ->take(5)
            ->get();


        return view(
            'kasir.dashboard',
            compact(
                'todayTransactions',
                'todaySales',
                'totalProducts',
                'lowStockProducts',
                'latestTransactions'
            )
        );
    }
}