<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\UserController; // Ensure correct namespace for UserController
use App\Http\Controllers\Admin\ProductController; // Make sure this controller is imported
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InventoryController;   




// Root route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Resource routes for Category, Supplier, and Product
Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('products', ProductController::class);

// Authentication routes
Auth::routes();

// Custom routes for login and registration
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Admin routes (protected by admin middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Admin routes for users management
    Route::resource('admin/users', UserController::class); // Admin user management
    
});

// User routes (protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'getDashboard'])->name('user.dashboard'); // User dashboard
});

// In web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'getDashboard'])->name('dashboard');
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'getDashboard'])->name('user.dashboard');
    });
});


// Define the profile route
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/admin', [AdminController::class, 'index'])->name('admin_home');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'getDashboard'])->name('admin.dashboard');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
});
Route::get('/admin/dashboard', [AdminController::class, 'getdashboard'])->name('admin.dashboard');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['web', 'auth']], function () {
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

// Route to show the profile edit form
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

// Route to handle the profile update
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'getDashboard'])->name('admin.dashboard');

    // Resource routes for user management
    Route::resource('admin/users', UserController::class);
});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'admin']) // Apply middleware as needed
    ->prefix('admin') // Set the prefix for admin routes
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'getDashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [AdminController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    });


    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::prefix('admin')->group(function() {
        Route::resource('products', ProductController::class)->names('admin.products');
    });

    Route::prefix('admin')->group(function() {
        Route::resource('orders', OrderController::class)->names('admin.orders');
    });

    Route::prefix('admin')->group(function() {
        Route::resource('orders', OrderController::class)->names('admin.orders');
    });

    Route::resource('admin/users', UserController::class);

    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');

    Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::get('admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');

    Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('Admin/dashboard');

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('Admin/dashboard');

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');


Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/user/products', [UserController::class, 'showProducts'])->name('user.products');
});




Route::post('/payment', [PaymentController::class, 'handlePayment'])->name('payment.handle');
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/failed', function () {
    return view('payments.failed');
})->name('payment.failed');



Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
Route::get('/payment/{order}', [CartController::class, 'handlePayment'])->name('payment.process');
Route::get('/order/success', [CartController::class, 'orderSuccess'])->name('order.success');    

Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('user.orders');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/orders', [OrderController::class, 'userOrders'])->name('user.orders');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/orders', [OrderController::class, 'userOrders'])->name('user.orders');
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/products', [UserController::class, 'showProducts'])->name('user.products.index');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/cart', [UserController::class, 'viewCart'])->name('user.cart.view');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'getDashboard'])->name('user.dashboard');
    Route::get('/user/products', [UserController::class, 'showProducts'])->name('user.products.index');
    Route::get('/user/cart', [UserController::class, 'viewCart'])->name('user.cart.view');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    // Add any other user routes here
});

Route::prefix('user')->group(function () {
    Route::get('products', [UserController::class, 'showProducts'])->name('user.products.index');
});


Route::get('/user/products', [UserController::class, 'showProducts'])->name('user.products.index');

// Define the route for viewing products
Route::get('/user/products', [UserController::class, 'showProducts'])->name('user.products.index');

// Define the route for adding to cart
Route::post('/user/cart/add/{id}', [UserController::class, 'addToCart'])->name('user.cart.add');

// Route for showing user products
Route::get('/user/products', [UserController::class, 'showProducts'])->name('user.products');

Route::prefix('user')->group(function () {
    Route::get('/products', [UserController::class, 'showProducts'])->name('user.products');
    // Other user-related routes...
});

// Route for adding a product to the cart
Route::post('/user/cart/add/{product}', [UserController::class, 'addToCart'])->name('user.cart.add');

// Route for showing the user's product index
Route::get('/user/products', [UserController::class, 'showProducts'])->name('user.products.index');

// Define route for user products
Route::get('/user/products', [UserController::class, 'showProducts'])->name('user.products');

// Define route for adding a product to the cart
Route::post('/user/cart/add/{product}', [UserController::class, 'addToCart'])->name('user.cart.add');

// Other routes...

// Define the route for showing the product list
Route::get('/user/products', [UserController::class, 'showProducts'])->name('user.products.index');

// Define the route for adding a product to the cart
Route::post('/user/cart/add/{product}', [UserController::class, 'addToCart'])->name('user.cart.add');

// Define the route for viewing the cart (if it exists)
Route::get('/user/cart', [UserController::class, 'viewCart'])->name('user.cart.view');

// Define the route for user orders (if it exists)
Route::get('/user/orders', [UserController::class, 'viewOrders'])->name('user.orders');

Route::get('/user/cart', [UserController::class, 'viewCart'])->name('user.cart.view');



Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/user/products', [ProductController::class, 'index'])->name('user.products.index');
    Route::get('/user/cart', [CartController::class, 'viewCart'])->name('user.cart.view');
    Route::get('/user/orders', [OrderController::class, 'index'])->name('user.orders');
});    

Route::get('/shop', [ShopController::class, 'index'])->name('shop');

Route::get('/user/dashboard', [UserController::class, 'getDashboard'])->name('user.dashboard');

// Admin Product Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('products', ProductController::class)->except(['show']);
});

// User Product Routes
Route::get('user/products', [ProductController::class, 'userIndex'])->name('user.products.index');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
});

Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');



Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'getDashboard'])->name('dashboard');
});

Route::post('/cart/add/{id}', [UserController::class, 'addToCart'])->name('user.cart.add');

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout');

Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout');

// routes/web.php

// Route to show the checkout form (GET request)
Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.form');

// Route to process the checkout form submission (POST request)
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout');

//Add this route for the checkout process
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

// Route to show the checkout form
Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout');

// Route to process the checkout form submission
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

// Add the route for viewing user order history
Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my.orders');

Route::get('/my-orders', [App\Http\Controllers\Admin\OrderController::class, 'userOrders'])->name('my.orders');

Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.form');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

Route::get('checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout');
Route::post('checkout', [CheckoutController::class, 'processCheckout']);
Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

Route::get('checkout/error', function () {
    return view('checkout.error'); // Ensure you have a view for this
})->name('checkout.error');

Route::post('checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/user/profile', [UserController::class, 'showProfile']);

Route::get('admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');

Route::get('admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
Route::get('admin/orders/{order}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'destroy']);
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

Route::get('/profile', [UserController::class, 'showProfile'])
    ->name('user.profile');

    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    Route::post('/checkout', [PaymentController::class, 'createPayment'])->name('checkout.process');
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');
Route::get('/checkout', function () {
    // Return your checkout view here
})->name('checkout');

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');

Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout');


Route::prefix('admin')->group(function () {
    Route::get('orders', [AdminController::class, 'showOrders'])->name('admin.orders.index');
});


Route::put('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.updatePicture');

Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('paypal/payment', [PayPalController::class, 'createPayment'])->name('paypal.payment');
Route::get('paypal/payment/success', [PayPalController::class, 'paymentSuccess'])->name('paypal.payment.success');
Route::get('paypal/payment/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.payment.cancel');


Route::get('paypal/payment', [PayPalController::class, 'createPayment'])->name('paypal.payment');
Route::get('paypal/status', [PayPalController::class, 'paymentStatus'])->name('paypal.status');
Route::get('paypal/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.cancel');
Route::get('payment/success', [PayPalController::class, 'paymentSuccess'])->name('payment.success');
Route::get('payment/failed', [PayPalController::class, 'paymentFailed'])->name('payment.failed');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/inventory/{productId}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::post('/inventory/{productId}/adjust', [InventoryController::class, 'adjustStock'])->name('inventory.adjust');
    Route::get('/inventory/{productId}/update', [InventoryController::class, 'updateStockForm'])->name('inventory.updateForm');
    Route::post('/inventory/{productId}/update', [InventoryController::class, 'updateStock'])->name('inventory.update');
});

Route::get('/inventory/{productId}', [InventoryController::class, 'show'])->name('inventory.show');
Route::post('/inventory/{productId}/adjust', [InventoryController::class, 'adjustStock'])->name('inventory.adjust');
Route::get('/inventory/{productId}/update', [InventoryController::class, 'updateStockForm'])->name('inventory.update.form');
Route::post('/inventory/{productId}/update', [InventoryController::class, 'updateStock'])->name('inventory.update');

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');


Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/inventory/{product}', [InventoryController::class, 'show'])->name('inventory.show');
Route::get('/inventory/{product}/update', [InventoryController::class, 'updateStockForm'])->name('inventory.updateStockForm');

Route::resource('products', ProductController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.updatePicture');
});



