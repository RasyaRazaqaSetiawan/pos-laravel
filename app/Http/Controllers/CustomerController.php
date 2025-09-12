<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

// Class
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource/Method.
     */
    public function index(Request $request)
    {
        // Property
        $search = $request->get('search');

        $customers = Customer::when($search, function ($query) use ($search) {
            return $query->where('full_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        })
            ->withCount('transactions')
            ->paginate(10);

        return view('Customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255|unique:customers,full_name',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'email' => 'nullable|email|unique:customers,email',
        ]);

        // Store Object
        $customer = new Customer();
        $customer->full_name = $request->full_name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Customer created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('Customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if ($customer->transactions()->exists()) {
            return back()->with('error', 'Cannot delete customer that has transaction history.');
        }

        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }
}
