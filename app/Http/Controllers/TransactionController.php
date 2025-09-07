<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\Concerns\Has;

class TransactionController extends Controller
{

    public function pos()
    {
        $customers = Customer::select(['id', 'full_name', 'phone'])
            ->orderBy('full_name')
            ->get();

        $products = Product::select(['id', 'name', 'price', 'stock'])
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('pos.index', [
            'customers' => $customers,
            'products' => $products
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $date = $request->get('date');

        $transactions = Transaction::when($search, function ($query) use ($search) {
            return $query->where('id', 'like', '%' . $search . '%')
                ->orWhereHas('customer', function ($customerQuery) use ($search) {
                    $customerQuery->where('full_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                });
        })
            ->when($date, function ($query) use ($date) {
                // Filter berdasarkan tanggal (hari dalam bulan)
                return $query->whereDay('created_at', $date);
            })
            ->with(['user', 'customer', 'items'])
            ->paginate(10);

        return view('Transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $customers = Customer::all();
        $users = User::all();
        return view('Transactions.create', compact('users', 'customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'customer_id.required' => 'Please select a customer first.',
            'customer_id.exists'   => 'The selected customer is not valid.',
            'items.required'       => 'Please add at least 1 product.',
            'items.*.product_id.exists' => 'The selected product is not valid.',
        ]);


        // Logical Quantity
        DB::transaction(function () use ($request) {
            $subtotal = 0;

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal += $product->price * $item['quantity'];
            }

            // Logical Discount
            $discount = 0;
            if ($subtotal > 1000000) {
                $discount = $subtotal * 0.15;
            } elseif ($subtotal > 500000) {
                $discount = $subtotal * 0.10;
            }

            $total = $subtotal - $discount;

            // Create Transaction
            $transaction = Transaction::create([
                'user_id' => $request->user()->id,
                'customer_id' => $request->customer_id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
            ]);

            // Save Transaction Items
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                $transaction->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }
        });
        return redirect()->route('transactions.index')->with('Success', 'Transactions is successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'customer', 'items.product']);

        return view('Transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $transaction->load(['items.product', 'customer', 'user']);
        $customers = Customer::all();
        $products = Product::all();

        return view('Transactions.edit', compact('transaction', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $transaction) {
            // Rollback/Kembalikan Stok Produk lama
            foreach ($transaction->items as $oldItem) {
                $oldItem->product->increment('stock', $oldItem->quantity);
            }
            // Delete All Old Items
            $transaction->items()->delete();

            // hitung sub total terbaru
            $subtotal = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal += $product->price * $item['quantity'];
            }

            $discount = 0;
            if ($subtotal > 1000000) {
                $discount = $subtotal * 0.15;
            } elseif ($subtotal > 500000) {
                $discount = $subtotal * 0.10;
            }

            $total = $subtotal - $discount;

            //  Update Transaksi
            $transaction->update([
                'customer_id' => $request->customer_id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
            ]);

            // Tambahkan item baru & kurangi stok
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                $transaction->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }
        });
        return redirect()->route('transactions.index')->with('Success', 'Transactions is Updated');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Transaction $transaction)
    // {
    //     //
    // }
}
