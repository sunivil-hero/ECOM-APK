<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('main');
})->name('main');

Route::get('/', [UserController::class, 'home'])->name('main');

Route::get('/product_detail/{id}', [UserController::class, 'ProductDetail'])
        ->name('product.detail');

        
        
       
Route::post('/add_to_cart/{id}', [UserController::class, 'CartAdd'])
     ->name('cart.add');


Route::get('/cartproducts', [UserController::class, 'CartProducts'])
     ->name('cartproducts');

     Route::get('/checkout', [UserController::class, 'CheckOut'])
     ->name('checkout');

     Route::post('/place-order', [UserController::class, 'placeOrder'])->name('checkout.place');

     Route::get('/payment-success', [UserController::class, 'success'])->name('payment.success');
Route::get('/payment-cancel', function() {
    return redirect()->route('main')->with('error', 'Payment was cancelled.');
})->name('payment.cancel');

     Route::delete('/remove/{id}', [UserController::class, 'Remove'])
            ->name('remove');

            // Route for the Shop Page
Route::get('/shop', [UserController::class, 'shop'])->name('shop');

Route::get('/why-us', [UserController::class, 'WhyUs'])->name('why-us');


Route::get('/testimonials', [UserController::class, 'Testimonials'])->name('testimonials');

Route::post('/testimonial', [UserController::class, 'storeTestimonial'])->name('testimonial.store');

Route::get('/contact', [UserController::class, 'Contact'])->name('contact');

Route::post('/contact', [UserController::class, 'storeContact'])->name('contact.store');

Route::post('/subscribe', [UserController::class, 'subscribe'])->name('subscribe');
/*
|--------------------------------------------------------------------------
| User Dashboard (Authenticated & Verified)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])
        ->name('dashboard');

        Route::get('/myorders', [UserController::class, 'MyOrders'])
            ->name('myorders');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::get('/category', [AdminController::class, 'category'])
            ->name('admin.category');

            Route::post('/category', [AdminController::class, 'addCategory'])
            ->name('admin.addcategory');
            
            Route::get('/view_category', [AdminController::class, 'viewCategory'])
            ->name('admin.Viewcategory');

            Route::delete('/delete_category/{id}', [AdminController::class, 'deleteCategory'])
            ->name('admin.deletecategory');

             Route::get('/edit_category/{id}', [AdminController::class, 'editCategory'])
            ->name('admin.editcategory');

             Route::put('/update_category/{id}', [AdminController::class, 'updateCategory'])
            ->name('admin.updatecategory');

             Route::get('/add_product', [AdminController::class, 'addProduct'])
            ->name('admin.addproduct');

            Route::post('/add_product', [AdminController::class, 'postAddProduct'])
            ->name('admin.postaddproduct');

            Route::get('/view_product', [AdminController::class, 'viewProduct'])
            ->name('admin.viewproduct');

             Route::get('/edit_product/{id}', [AdminController::class, 'editProduct'])
            ->name('admin.editproduct');

             Route::put('/update_product/{id}', [AdminController::class, 'updateProduct'])
            ->name('admin.updateproduct');

            Route::delete('/delete_product/{id}', [AdminController::class, 'deleteProduct'])
            ->name('admin.deleteproduct');

            Route::any('/search_products', [AdminController::class, 'postSearchProducts'])
            ->name('admin.searchproducts');
            Route::get('/view_orders', [AdminController::class, 'ViewOrders'])
    ->name('admin.vieworders');

 Route::get('/edit_order/{id}', [AdminController::class, 'EditOrder'])
    ->name('admin.editorder');


Route::put('/update-status/{id}', [AdminController::class, 'updateStatus'])
     ->name('admin.updatestatus');


Route::put('/update-status/{id}', [AdminController::class, 'updateStatus'])
     ->name('admin.updatestatus');
     
     Route::get('/download-invoice/{id}', [AdminController::class, 'downloadInvoice'])
     ->name('admin.downloadInvoice');

     Route::get('/messages', [AdminController::class, 'messages'])
     ->name('admin.messages');

     Route::delete('/admin/messages/{id}', [UserController::class, 'deleteMessage'])
     ->name('admin.messages.delete');

Route::get('/dashboard', [AdminController::class, 'Home'])
            ->name('dashboard');


             Route::post('/storeproduct', [AdminController::class, 'storeProduct'])
            ->name('admin.storeproduct');

            



     

Route::prefix('admin')
->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');

        
});
        


/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
