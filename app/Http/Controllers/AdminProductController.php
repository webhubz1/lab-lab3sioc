<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import AuthorizesRequests trait

class AdminProductController extends Controller // Extend the base Controller class
{
    use AuthorizesRequests; // Use the AuthorizesRequests trait

    /**
     * Display a listing of the products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Initialize the query builder for the Product model
        $query = Product::query();
    
        // Check if there's a search query in the request
        if ($request->has('search')) {
            // Apply a 'like' filter to the 'product_name' column
            $query->where('product_name', 'like', '%' . $request->input('search') . '%');
        }
    
        // Eager load the 'stock' relationship to avoid the error
        $products = $query->with('stock')->paginate(10); // Paginate results if needed
    
        // Return the view with the list of products, including stock data
        return view('inventory.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create(): \Illuminate\View\View
    {
        // Return the 'create' view to show the product creation form
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('create', Product::class); // This should now work

        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_name' => 'required|string|min:3|max:255|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);

        // Check if an image file was uploaded
        if ($request->hasFile('image')) {
            // Generate a unique name for the image
            $imageName = time() . '.' . $request->image->extension();
            // Move the image to the 'images' directory
            $request->image->move(public_path('images'), $imageName);
            // Add the image name to the validated data
            $validatedData['image'] = $imageName;
        }

        // Ensure description is not null
        $validatedData['description'] = $validatedData['description'] ?? '';

        // Create a new product record in the database
        Product::create($validatedData);

        // Redirect to the products index page with a success message
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product): \Illuminate\View\View
    {
        // Return the 'edit' view with the product data
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_name' => 'required|string|min:3|max:255|unique:products,product_name,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sizes' => 'nullable|string',
            'stock' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);

        // Check if an image file was uploaded
        if ($request->hasFile('image')) {
            // Generate a unique name for the new image
            $imageName = time() . '.' . $request->image->extension();
            // Move the new image to the 'images' directory
            $request->image->move(public_path('images'), $imageName);
            // Add the new image name to the validated data
            $validatedData['image'] = $imageName;

            // Delete the old image if it exists
            if ($product->image && file_exists(public_path('images/' . $product->image))) {
                unlink(public_path('images/' . $product->image));
            }
        }

        // Ensure description is not null
        $validatedData['description'] = $validatedData['description'] ?? '';

        // Update the existing product record with the validated data
        $product->update($validatedData);

        // Redirect to the products index page with a success message
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product): \Illuminate\Http\RedirectResponse
    {
        // Delete the image if it exists
        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        // Delete the product record from the database
        $product->delete();

        // Redirect to the products index page with a success message
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
    public function show($id)
    {
        $product = Product::with('stock')->findOrFail($id); // Eager load stock
        return view('products.show', compact('product')); // Adjust the view name as necessary
    }

}
