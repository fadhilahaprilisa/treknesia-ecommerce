<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DataService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    // ============ DASHBOARD ============
    public function dashboard()
    {
        $products = $this->dataService->getProducts();
        $orders = $this->dataService->getOrders();
        $users = $this->dataService->getUsers();

        $totalProducts = count($products);
        $totalOrders = count($orders);
        $totalRevenue = collect($orders)->where('status', 'PAID')->sum('total_amount');
        $pendingOrders = collect($orders)->where('status', 'PENDING')->count();
        $paidOrders = collect($orders)->where('status', 'PAID')->count();
        $shippedOrders = collect($orders)->where('status', 'SHIPPED')->count();

        $recentOrders = collect($orders)
            ->sortByDesc('created_at')
            ->take(5)
            ->values()
            ->all();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalOrders', 'totalRevenue',
            'pendingOrders', 'paidOrders', 'shippedOrders',
            'recentOrders'
        ));
    }

    // ============ PRODUK ============
    public function products()
    {
        $products = $this->dataService->getProducts();
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = $this->dataService->getCategories();
        return view('admin.products.create', compact('categories'));
    }

    // ✅ Method storeProduct — tanpa rating
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string',
            'gender' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'brand' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Set rating default 4.5 untuk produk baru
        $validated['rating'] = 4.5;
        $validated['specs'] = [];

        // Handle upload gambar
        if ($request->hasFile('image')) {
            $uploadPath = public_path('images/products');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('image');
            $filename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['image'] = '/images/products/' . $filename;
        } else {
            $validated['image'] = 'https://placehold.co/400x400/0D1C2D/34d399?text=' . urlencode($validated['name']);
        }

        $this->dataService->addProduct($validated);

        return redirect('/admin/products')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function editProduct($id)
    {
        $product = $this->dataService->getProductById($id);
        if (!$product) {
            return redirect('/admin/products')->with('error', 'Produk tidak ditemukan.');
        }
        $categories = $this->dataService->getCategories();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // ✅ Method updateProduct — HANYA SATU, tanpa rating
    public function updateProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string',
            'gender' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'brand' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Rating TIDAK diupdate (biarkan existing)

        // Handle upload gambar baru
        if ($request->hasFile('image')) {
            $uploadPath = public_path('images/products');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('image');
            $filename = 'product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['image'] = '/images/products/' . $filename;
        } else {
            unset($validated['image']);
        }

        $this->dataService->updateProduct($id, $validated);

        return redirect('/admin/products')->with('success', 'Produk berhasil diupdate!');
    }

    public function deleteProduct($id)
    {
        $this->dataService->deleteProduct($id);
        return redirect('/admin/products')->with('success', 'Produk berhasil dihapus!');
    }

    // ============ PESANAN ============
    public function orders(Request $request)
    {
        $orders = $this->dataService->getOrders();
        $orders = collect($orders)->sortByDesc('created_at')->values()->all();

        if ($request->has('status') && $request->status) {
            $orders = collect($orders)->where('status', $request->status)->values()->all();
        }

        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = $this->dataService->getOrderById($id);
        if (!$order) {
            return redirect('/admin/orders')->with('error', 'Pesanan tidak ditemukan.');
        }
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:PENDING,PAID,SHIPPED,CANCELLED'
        ]);

        $this->dataService->updateOrderStatus($id, $request->status);
        return back()->with('success', 'Status pesanan berhasil diupdate!');
    }

    // ============ LAPORAN ============
    public function reports(Request $request)
    {
        $orders = $this->dataService->getOrders();
        
        if ($request->has('from') && $request->from) {
            $orders = collect($orders)->filter(function($o) use ($request) {
                return $o['created_at'] >= $request->from . ' 00:00:00';
            })->values()->all();
        }
        if ($request->has('to') && $request->to) {
            $orders = collect($orders)->filter(function($o) use ($request) {
                return $o['created_at'] <= $request->to . ' 23:59:59';
            })->values()->all();
        }

        $totalRevenue = collect($orders)->where('status', 'PAID')->sum('total_amount');
        $totalOrders = count($orders);
        $paidOrders = collect($orders)->where('status', 'PAID')->count();
        $pendingOrders = collect($orders)->where('status', 'PENDING')->count();

        $orders = collect($orders)->sortByDesc('created_at')->values()->all();

        return view('admin.reports.index', compact(
            'orders', 'totalRevenue', 'totalOrders', 'paidOrders', 'pendingOrders'
        ));
    }
}