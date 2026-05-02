<?php

namespace App\Http\Controllers;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\productcart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Testimonial;
use App\Models\Contact;
use App\Models\Subscription;
class userController extends Controller
{
    public function index(){
        if (!Auth::check()) {
            return redirect('/login');
        }

        
        if (Auth::user()->user_type == 'admin') {
            return view('admin.dashboard'); // admin dashboard
        }

        if (Auth::user()->user_type == 'user') {
            return view('dashboard'); // regular user dashboard
        }

    }
    public function home()
    {
        if (Auth::check()) {
            $count = ProductCart::where('user_id', Auth::id())->count();
        }else{
            $count = '';
        }
      $products = Product::latest()->take(6)->get();
        return view('main', compact('products', 'count'));
    }
    public function ProductDetail(int $id)
    {
          if (Auth::check()) {
            $count = ProductCart::where('user_id', Auth::id())->count();
        }else{
            $count = '';
        }
        $product = Product::findOrFail($id);
        return view('product_detail', compact('product' , 'count'));
    }
    public function ViewAll()
    {
          if (Auth::check()) {
            $count = ProductCart::where('user_id', Auth::id())->count();
        }else{
            $count = '';
        }
        $products = Product::all();
        return view('allproducts', compact('products', 'count'));
    }

   public function CartAdd(int $id)
{
    
    if (!Auth::check()) {
        return redirect()->route('login')
                         ->with('error', 'Please login to add products to your cart.');
    }

    
    $product = Product::findOrFail($id);
    if ($product->quantity < 1) {
        return redirect()->back()
                         ->with('error', 'Sorry, this product is out of stock!');
    }

    // Check if the product is already in the user's cart
    $existingItem = ProductCart::where('user_id', Auth::id())
                               ->where('product_id', $id)
                               ->first();

    if ($existingItem) {
        // Increase quantity if already in cart
        $existingItem->quantity += 1;
        $existingItem->save();

        return redirect()->back()
                         ->with('cart_message', 'Product quantity updated in your cart!');
    }

    // Add new item to cart (Clean & Recommended)
    ProductCart::create([
        'user_id'    => Auth::id(),
        'product_id' => $id,
        'quantity'   => 1,
    ]);

    return redirect()->back()
                     ->with('cart_message', 'Product added to cart successfully!');
}
public function CartProducts()
{
    if (Auth::check()) {
        $cart = ProductCart::where('user_id', Auth::id())->get();
        // Calculate total
        $total = $cart->sum(function($item) {
            return $item->quantity * $item->product->price;
        });
        $count = $cart->count();
    } else {
        $cart = collect(); // empty collection
        $total = 0;
        $count = 0;
    }
    return view('cartproducts', compact('cart', 'total', 'count'));
}

/**
 * Show Checkout Page
 */
public function checkout()
{
    if (!Auth::check()) {
        return redirect()->route('login')
                         ->with('error', 'Please login to proceed to checkout.');
    }

    // Get cart items with product details
    $cartItems = ProductCart::with('product')
                            ->where('user_id', Auth::id())
                            ->get();

    $count = $cartItems->sum('quantity');

    // Calculate total amount
    $total = $cartItems->sum(function($item) {
        return $item->quantity * $item->product->price;
    });

    return view('checkout', compact('cartItems', 'total', 'count'));
}

    /**
     * Process the Order (Place Order)
     */
   public function placeOrder(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login to place an order.');
    }

    $userId = Auth::id();
    $cartItems = ProductCart::with('product')->where('user_id', $userId)->get();

    if ($cartItems->isEmpty()) {
        return redirect()->back()->with('error', 'Your cart is empty!');
    }

    foreach ($cartItems as $item) {
        if ($item->quantity > $item->product->quantity) {
            return redirect()->back()->with('error', "Sorry, we only have {$item->product->quantity} of {$item->product->product_name} in stock.");
        }
    }
    $lineItems = [];
    foreach ($cartItems as $item) {
        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $item->product->product_name,
                ],
                'unit_amount' => $item->product->price * 100, // Stripe inasoma cents
            ],
            'quantity' => $item->quantity,
        ];
    }

    
    // 1. Authenticate with Stripe using the config bridge
\Stripe\Stripe::setApiKey(config('services.stripe.secret'));

// 2. Build the Checkout Session
$checkoutSession = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $lineItems,
    'mode' => 'payment',
    'success_url' => route('payment.success'),
    'cancel_url' => route('payment.cancel'),
]);

// 3. Send the user to the Stripe payment page
return redirect()->away($checkoutSession->url);

    
    session(['temp_order_data' => [
        'full_name' => $request->full_name,
        'phone' => $request->phone,
        'shipping_address' => $request->shipping_address,
    ]]);

    return redirect($checkoutSession->url);
}
    public function Remove( int $id)
    {
       $remove = ProductCart::findOrFail($id);
       $remove->delete();
       return redirect()->back()->with('success', 'Item removed from cart successfully!');
    }

    public function MyOrders()
{
    if (!Auth::check()) {
        return redirect()->route('login')
            ->with('error', 'Please login to view your orders.');
    }

    $orders = Order::with('products')   
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

    return view('myorders', compact('orders'));
}
public function success()
{
    // 1. Pata ID ya mteja aliyelogin
    $userId = Auth::id();

    // 2. Chukua taarifa za shipping tulizozihifadhi kwenye session wakati wa placeOrder
    $shipping = session('temp_order_data'); 

    // 3. Chukua bidhaa zilizopo kwenye Cart kwa ajili ya huyu mteja
    $cartItems = ProductCart::with('product')->where('user_id', $userId)->get();

    // 4. Usalama: Hakikisha kuna shipping data na Cart haina tupu
    if (!$shipping || $cartItems->isEmpty()) {
        return redirect()->route('main')->with('error', 'Samahani, tumeshindwa kukamilisha oda yako.');
    }

    // 5. Tumia DB Transaction ili kuhakikisha kila kitu kinasave kwa usalama
    DB::transaction(function () use ($userId, $shipping, $cartItems) {
        
        // A. Kutengeneza Oda kuu (Order)
        $order = Order::create([
            'user_id'          => $userId,
            'total_amount'     => $cartItems->sum(fn($item) => $item->quantity * $item->product->price),
            'full_name'        => $shipping['full_name'],
            'phone'            => $shipping['phone'],
            'shipping_address' => $shipping['shipping_address'],
            'status'           => 'paid', // Tayari ameshalipa kule Stripe
        ]);

        // B. Kuhamisha bidhaa moja moja kwenda kwenye OrderItems
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity'   => $cartItem->quantity,
                'price'      => $cartItem->product->price,
            ]);
        }

        // C. Safisha Cart ya mteja kwa sababu ameshanunua
        ProductCart::where('user_id', $userId)->delete();

        // D. Futa ile session ya muda tuliyotumia kuhifadhi address
        session()->forget('temp_order_data');
    });

    // 6. Mrejeshe mteja kwenye ukurasa wa bidhaa na ujumbe wa mafanikio
    return redirect()->route('main')->with('success', 'Hongera! Malipo yamefanikiwa na oda yako imepokelewa.');
}

public function shop()
{
    if (Auth::check()) {
        $count = ProductCart::where('user_id', Auth::id())->count();
    } else {
        $count = '';
    }
    $products = Product::all();
    return view('shop', compact('products', 'count'));
}
public function WhyUs()
{
    $count = 0;
    return view('why-us', compact('count'));
}

 // Method to display the page
    public function Testimonials()
    {
        $count = 0;
        if (Auth::check()) {
            $count = ProductCart::where('user_id', Auth::id())->count();
        }

        // Fetch all reviews from the database
        $testimonial = Testimonial::latest()->get();

        return view('testimonial', compact('count', 'testimonial'));
    }

    // Method to save a new review
    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create([
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Thank you! Your review has been posted.');
    }
public function Contact(){
    $count = 0;
    if (Auth::check()) {
        $count = ProductCart::where('user_id', Auth::id())->count();
    }
    return view('contact', compact('count'));
}
public function storeContact(Request $request){
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'message' => 'required|string',
    ]);

    Contact::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'message' => $request->message,
    ]);

    return redirect()->back()->with('success', 'Thank you! Your message has been sent.');

}
public function subscribe(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:subscriptions,email',
    ]);

    // Hifadhi email kwenye database (tutaleta model ya Subscription)
    \App\Models\Subscription::create([
        'email' => $request->email,
    ]);

    return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
}
}
