<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();

        return response()->json([
            'message' => 'Items retrieved successfully.',
            'data' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'unit_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'The name field is required.',
            'unit_price.required' => 'The unit price field is required.',
            'unit_price.numeric' => 'The unit price must be a number.',
            'unit_price.min' => 'The unit price must be at least 0.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least 1.',
        ]);

        
        // Calculate the amount based on quantity and unit_price
        $validatedData['amount'] = $validatedData['quantity'] * $validatedData['unit_price'];

        $item = Item::create($validatedData);

        return response()->json([
            'message' => 'Item created successfully.',
            'data' => $item,
        ], 201);
    }

    public function show(Item $item)
    {
        return response()->json([
            'message' => 'Item retrieved successfully.',
            'data' => $item,
        ]);
    }

    public function update(Request $request, Item $item)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'unit_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'The name field is required.',
            'unit_price.required' => 'The unit price field is required.',
            'unit_price.numeric' => 'The unit price must be a number.',
            'unit_price.min' => 'The unit price must be at least 0.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least 1.',
        ]);

        // Calculate the amount based on quantity and unit_price
        $validatedData['amount'] = $validatedData['quantity'] * $validatedData['unit_price'];

        $item->update($validatedData);

        return response()->json([
            'message' => 'Item updated successfully.',
            'data' => $item,
        ]);
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json([
            'message' => 'Item deleted successfully.',
        ]);
    }
}
