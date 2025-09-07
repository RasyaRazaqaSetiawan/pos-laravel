<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todaySales = Transaction::whereDate('created_at', now())->sum('total');
        $todayTransactions = Transaction::whereDate('created_at', now())->count();
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();

        return view('dashboard', compact(
            'todaySales',
            'todayTransactions',
            'totalProducts',
            'totalCustomers'
        ));
    }
}
