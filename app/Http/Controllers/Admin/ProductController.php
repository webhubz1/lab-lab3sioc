<?php

namespace App\Http\Controllers\Admin; // Use the correct namespace

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;   

class ProductController extends Controller
{
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

        // Get the filtered products
        $products = $query->get();

        // Return the 'index' view with the list of products
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Return the 'create' view to show the product creation form
        return view('admin.products.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_name' => 'required|string|min:3|max:255|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount' => 'nullable|numeric|min:0|max:100',
            'size' => 'nullable|string',
            'sizes.*.size' => 'required|string',
        'sizes.*.stock' => 'required|integer|min:0',
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
    public function edit(Product $product)
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
    public function update(Request $request, Product $product)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'product_name' => 'required|string|min:3|max:255|unique:products,product_name,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'discount' => 'nullable|numeric|min:0|max:100',
            'size' => 'nullable|numeric',
            'sizes.*.size' =>  'nullable|numeric',
        'sizes.*.stock' =>  'nullable|numeric',
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
    public function destroy(Product $product)
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

    public function userIndex(Request $request)
{
    $query = Product::query();

    // Check if there's a search query in the request
    if ($request->has('search')) {
        $query->where('product_name', 'like', '%' . $request->input('search') . '%');
    }

    // Get the filtered products
    $products = $query->paginate(10); // Optional: paginate the results for better UX

    // Return the user 'index' view with the list of products
    return view('user.products.index', compact('products')); // Ensure you're using the correct view path
}
public function show($id)
{
    $product = Product::with('stock')->findOrFail($id); // Eager load stock
    return view('products.show', compact('product')); // Adjust the view name as necessary
}

}


