<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return response()->json([
            'message' => 'Customers retrieved successfully.',
            'data' => $customers,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
        ]);

        $customer = Customer::create($validatedData);

        return response()->json([
            'message' => 'Customer created successfully.',
            'data' => $customer,
        ], 201);
    }

    public function show(Customer $customer)
    {
        return response()->json([
            'message' => 'Customer retrieved successfully.',
            'data' => $customer,
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
        ]);

        $customer->update($validatedData);

        return response()->json([
            'message' => 'Customer updated successfully.',
            'data' => $customer,
        ]);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully.',
        ]);
    }
}
