<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InventoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the stock levels.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::with('stock')
            ->when($search, function ($query) use ($search) {
                return $query->where('product_name', 'like', "%{$search}%");
            })
            ->paginate(10); // Adjust the number of items per page as needed

        return view('inventory.index', compact('products'));
    
}
    /**
     * Show the form for creating a new stock entry.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Retrieve all products to associate with stock
        $products = Product::all();

        // Return the 'create' view to show the stock creation form
        return view('inventory.create', compact('products'));
    }

    /**
     * Store a newly created stock entry in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Stock::class);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        // Create a new stock record in the database
        Stock::create($validatedData);

        // Redirect to the inventory index page with a success message
        return redirect()->route('inventory.index')->with('success', 'Stock created successfully.');
    }

    /**
     * Show the form for editing the specified stock entry.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\View\View
     */
    public function edit(Stock $stock)
    {
        // Retrieve all products to associate with stock
        $products = Product::all();

        // Return the 'edit' view with the stock data
        return view('inventory.edit', compact('stock', 'products'));
    }

    /**
     * Update the specified stock entry in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Stock $stock)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_available' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
        ]);

        // Update the existing stock record with the validated data
        $stock->update($validatedData);

        // Redirect to the inventory index page with a success message
        return redirect()->route('inventory.index')->with('success', 'Stock updated successfully.');
    }

    /**
     * Remove the specified stock entry from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Stock $stock)
    {
        // Delete the stock record from the database
        $stock->delete();

        // Redirect to the inventory index page with a success message
        return redirect()->route('inventory.index')->with('success', 'Stock deleted successfully.');
    }

    /**
     * Adjust stock levels when an order is placed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adjustStock(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the stock record for the specified product
        $stock = Stock::where('product_id', $validatedData['product_id'])->first();

        if ($stock) {
            // Adjust the stock level
            $stock->quantity_available -= $validatedData['quantity'];

            // Ensure stock does not go below zero
            if ($stock->quantity_available < 0) {
                $stock->quantity_available = 0;
            }

            // Save the updated stock record
            $stock->save();

            // Redirect to the inventory index page with a success message
            return redirect()->route('inventory.index')->with('success', 'Stock adjusted successfully.');
        }

        // If stock record does not exist, redirect with an error message
        return redirect()->route('inventory.index')->with('error', 'Stock record not found.');
    }

    
}
