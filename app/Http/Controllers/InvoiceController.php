<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();

        return response()->json([
            'message' => 'Invoices retrieved successfully.',
            'data' => $invoices,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
        ], [
            'customer_id.required' => 'The customer field is required.',
            'customer_id.exists' => 'The selected customer is invalid.',
            'item_id.required' => 'The item field is required.',
            'item_id.exists' => 'The selected item is invalid.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least 1.',
            'issue_date.required' => 'The issue date field is required.',
            'issue_date.date' => 'The issue date must be a valid date.',
            'due_date.required' => 'The due date field is required.',
            'due_date.date' => 'The due date must be a valid date.',
            'due_date.after_or_equal' => 'The due date must be equal to or after the issue date.',
        ]);

        $item = Item::find($validatedData['item_id']);

        // Check if requested quantity is available
        if ($item->quantity < $validatedData['quantity']) {
            return response()->json([
                'message' => 'Not enough stock available for the requested quantity.',
            ], 400);
        }

        $invoice = Invoice::create($validatedData);


        // Update the item quantity and amount
        $item->quantity -= $validatedData['quantity'];
        $item->amount = $item->unit_price * $item->quantity; // Calculate the new amount
        $item->save();

        return response()->json([
            'message' => 'Invoice created successfully.',
            'data' => $invoice,
        ], 201);
    }

    public function show(Invoice $invoice)
    {
        return response()->json([
            'message' => 'Invoice retrieved successfully.',
            'data' => $invoice,
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
        ], [
            'customer_id.required' => 'The customer field is required.',
            'customer_id.exists' => 'The selected customer is invalid.',
            'item_id.required' => 'The item field is required.',
            'item_id.exists' => 'The selected item is invalid.',
            'quantity.required' => 'The quantity field is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least 1.',
            'issue_date.required' => 'The issue date field is required.',
            'issue_date.date' => 'The issue date must be a valid date.',
            'due_date.required' => 'The due date field is required.',
            'due_date.date' => 'The due date must be a valid date.',
            'due_date.after_or_equal' => 'The due date must be equal to or after the issue date.',
        ]);

        $item = Item::find($validatedData['item_id']);

        // Check if requested quantity is available
        if ($item->quantity < $validatedData['quantity']) {
            return response()->json([
                'message' => 'Not enough stock available for the requested quantity.',
            ], 400);
        }

        // Restore the previous quantity before updating
        $item = Item::find($invoice->item_id);//
        $item->quantity += $invoice->quantity;
        $item->amount = $item->unit_price * $item->quantity; //
        $item->save();

        $invoice->update($validatedData);

        // Update the item quantity
        $item->quantity -= $validatedData['quantity'];
        $item->amount = $item->unit_price * $item->quantity; // Calculate the new amount
        $item->save();

        return response()->json([
            'message' => 'Invoice updated successfully.',
            'data' => $invoice,
        ]);
    }

    public function destroy(Invoice $invoice)
    {
        // Restore the item quantity before deleting the invoice
        $item = Item::find($invoice->item_id);
        $item->quantity += $invoice->quantity;
        $item->amount = $item->unit_price * $item->quantity; // Calculate the new amount
        $item->save();

        $invoice->delete();

        return response()->json([
            'message' => 'Invoice deleted successfully.',
        ]);
    }
}
