<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Category; 
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Contact;
use App\Models\User;
class AdminController extends Controller

{

    public function category()
    {
        return view("admin.addcategory");
    }

    public function index()
    {
        return view("admin.dashboard");
    }

    public function addCategory(Request $request)
    {
        $category = new Category();
        $category->category=$request->category;
        $category->save();
        return redirect()->back()->with('category_message', 'Category added successfully!');
    }
     public function viewCategory()
    {
        $categories = Category::paginate(5);
        return view('admin.viewcategory', compact('categories'));
    }
    public function deleteCategory( int $id)
    {
$category = Category::findorFail($id);

$category->delete();
        return redirect()->back()->with('category_message', 'Category deleted successfully!');

    }
  public function editCategory( int $id)
{
    $category = Category::findOrFail($id);
    return view('admin.editcategory', compact('category'));
}
    
public function updateCategory(Request $request, int $id)
{
  $category = Category::findorFail($id);  

$category->category=$request->category;
$category->save();
        return redirect()->back()->with('category_message', 'Category updated successfully!');
}

public function addProduct()
{
    $categories = Category::all();
    return view ('admin.addproduct' , compact('categories'));
}

public function postAddProduct(Request $request)
{
    // Validation - Ongeza quantity hapa
    $request->validate([
        'product_name'        => 'required|string|max:255',
        'category_id'         => 'required|integer|exists:categories,id',
        'price'               => 'required|numeric|min:0',
        'quantity'            => 'required|integer|min:0',           // ← Ongeza hii
        'product_description' => 'nullable|string',
        'image'               => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // Create new product
    $product = new Product();
    $product->product_name        = $request->product_name;
    $product->category_id         = $request->category_id;
    $product->price               = $request->price;
    $product->quantity            = $request->quantity;        
    $product->product_description = $request->product_description;

    // Handle image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
    }

    $product->save();

    return redirect()->route('admin.addproduct')
        ->with('product_message', 'Product added successfully!');
}


public function viewProduct()
{
  $query = Product::with('category')->latest();

    // Filter by Category
    if (request('category_id')) {
        $query->where('category_id', request('category_id'));
    }

    $products = $query->paginate(10);   // Unaweza kubadilisha 10 kuwa 5 au 15

    $categories = Category::all();

    return view('admin.viewproduct', compact('products', 'categories'));
}


  public function editProduct( int $id)
{
    $product = Product::findOrFail($id);
    $categories = Category::all();
    return view('admin.editproduct', compact('product', 'categories'));
}
public function updateProduct(Request $request, int $id)
{
  $product = Product::findorFail($id);  

$product->product_name=$request->product_name;
$product->category_id=$request->category_id;
$product->price=$request->price;
$product->quantity=$request->quantity;
$product->product_description=$request->product_description;
$product->save();
        return redirect()->back()->with('product_message', 'Product updated successfully!');
} 

public function deleteProduct( int $id)
    {
$product = Product::findorFail($id);
if ($product->image) {
        $image_path = public_path('storage/' . $product->image);
        
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
$product->delete();
        return redirect()->back()->with('product_message', 'Product deleted successfully!');

    }

public function postSearchProducts(Request $request)
{
    $products = Product::where('product_name', 'like', '%' . $request->search . '%')
                        ->orWhere('product_description', 'like', '%' . $request->search . '%')
                         ->orWhere('quantity', 'like', '%' . $request->search . '%')
                          ->orWhere('category_id', 'like', '%' . $request->search . '%')
                        ->paginate(2);
    return view('admin.viewproduct', compact('products'));
}

public function ViewOrders()
{
    $orders = Order::with('orderItems.product') 
                   ->latest()
                   ->paginate(10);
    return view('admin.vieworders', compact('orders'));
}

public function EditOrder( int $id)
{
   $order = Order::with('orderItems')->findOrFail($id);

    return view('admin.editorder', compact('order'));
}

/**
 * Update Order Status from the Edit Order page
 */
public function updateStatus(Request $request, int $id)
{
    $request->validate([
        'status' => 'required|in:pending,shipped,completed,cancelled',
    ]);


    $order = Order::findOrFail($id);


    $order->status = $request->status;
    $order->save();



    return redirect()->back()
                     ->with('success', 'Order status updated successfully to ' . ucfirst($request->status) . '!');
}

public function updateOrder(Request $request, int $id)
{
    $order = Order::findOrFail($id);

    $order->update([
        'full_name'        => $request->full_name,
        'phone'            => $request->phone,
        'shipping_address' => $request->shipping_address,
        'status'           => $request->status,
        'total_amount'     => $request->total_amount,
    ]);

    return redirect()->route('admin.vieworders')
                     ->with('success', 'Order updated successfully!');
}

public function downloadInvoice(int $id)
{
    // Eager load 'user' to get the customer's name and email
    $order = Order::with(['orderItems.product', 'user'])->findOrFail($id);

    // Try to get name from order table, if null, get it from the user relationship
    $customerName = $order->customer_name ?? ($order->user->name ?? 'N/A');
    $customerEmail = $order->customer_email ?? ($order->user->email ?? 'N/A');
    $shippingAddress = $order->shipping_address ?? 'N/A';

    $data = compact('order', 'customerName', 'customerEmail', 'shippingAddress');

    $pdf = PDF::loadView('admin.invoice', $data);

    return $pdf->download('invoice_order_' . $order->id . '.pdf');
}
public function messages()
{
    $messages = \App\Models\Contact::orderBy('created_at', 'desc')->get();
    return view('admin.messages', compact('messages'));
}

public function deleteMessage(int $id)
{
    $message = Contact::findOrFail($id);
    $message->delete();
    return redirect()->back()->with('success', 'Message deleted successfully!');
}

public function Home()
{
    // Sales performance (daily totals)
    $salesData = Order::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(total_amount) as total_sales')
    )
    ->groupBy('date')
    ->orderBy('date', 'asc')
    ->get();

    $salesLabels = $salesData->pluck('date')->map(function($date) {
        return Carbon::parse($date)->format('M d');
    });

    $salesData = $salesData->pluck('total_sales');

    // Top products by sold quantity
    $topProducts = OrderItem::with('product')
        ->select('product_id', DB::raw('SUM(quantity) as product_sales'))
        ->groupBy('product_id')
        ->orderByDesc('product_sales')
        ->limit(5)
        ->get();

    if ($topProducts->isNotEmpty()) {
        $productNames = $topProducts->map(fn($item) => $item->product?->product_name ?? 'Unknown');
        $productSales = $topProducts->pluck('product_sales');
    } else {
        $productNames = Product::pluck('product_name');
        $productSales = Product::pluck('quantity');
    }

    // Dashboard metrics
    $totalAmount = Order::sum('total_amount');
    $totalOrders = Order::count();
    $totalCustomers = User::count();
    $productsInStock = Product::where('quantity', '>', 0)->count();

    $recentOrders = Order::with('orderItems.product')
        ->latest()
        ->limit(5)
        ->get();

    $recentCustomers = User::latest()
        ->limit(5)
        ->get();

    return view('admin.dashboard', compact(
        'salesLabels',
        'salesData',
        'productNames',
        'productSales',
        'totalAmount',
        'totalOrders',
        'totalCustomers',
        'productsInStock',
        'recentOrders',
        'recentCustomers'
    ));
}

}