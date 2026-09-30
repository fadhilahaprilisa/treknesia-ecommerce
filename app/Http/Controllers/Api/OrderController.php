<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_whatsapp' => 'required|string|max:20',
            'customer_address' => 'required|string|max:255',
            'customer_city' => 'required|string|max:50',
            'payment_method' => 'nullable|string|in:COD,QRIS',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.size' => 'nullable|string|max:20',
            // ✅ Tambahan: terima harga dari frontend
            'items.*.price' => 'nullable|numeric|min:0',
            'items.*.original_price' => 'nullable|numeric|min:0',
            'items.*.bundle_name' => 'nullable|string|max:50',
        ]);

        $totalPrice = 0;
        $orderItems = [];

        foreach ($validated['items'] as $item) {
            $product = $this->dataService->getProductById($item['product_id']);
            
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Product with ID {$item['product_id']} not found"
                ], 404);
            }

            // ✅ PRIORITAS: Pakai harga dari frontend (kalau ada), fallback ke harga produk
            $finalPrice = isset($item['price']) && $item['price'] > 0 
                ? $item['price'] 
                : $product['price'];

            $subtotal = $finalPrice * $item['quantity'];
            $totalPrice += $subtotal;

            $orderItems[] = [
                'product_id' => $product['id'],
                'product_name' => $product['name'],
                'price' => $finalPrice,                           // ✅ Harga dari frontend
                'original_price' => $item['original_price'] ?? null,  // ✅ Simpan harga asli
                'quantity' => $item['quantity'],
                'size' => $item['size'] ?? null,
                'bundle_name' => $item['bundle_name'] ?? null,    // ✅ Tag bundle
                'subtotal' => $subtotal
            ];
        }

        $shippingCost = $this->dataService->calculateShipping($validated['customer_city']);
        $totalAmount = $totalPrice + $shippingCost;
        $orderId = $this->dataService->generateOrderId();

        $order = [
            'id' => $orderId,
            'order_id' => $orderId,
            'customer_name' => $validated['customer_name'],
            'customer_whatsapp' => $validated['customer_whatsapp'],
            'customer_address' => $validated['customer_address'],
            'customer_city' => $validated['customer_city'],
            'payment_method' => $validated['payment_method'] ?? 'COD',
            'items' => $orderItems,
            'total_price' => $totalPrice,
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
            'status' => 'PENDING',
            'payment' => null,
            'payment_status' => 'NONE',
            'payment_proof' => null,
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString()
        ];

        $this->dataService->saveOrder($order);

        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
            'data' => [
                'order_id' => $orderId,
                'id' => $orderId,
                'total_amount' => $totalAmount,
                'status' => 'PENDING',
                'order' => $order
            ]
        ], 201);
    }

    public function show($id)
    {
        $order = $this->dataService->getOrderById($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        if (!isset($order['order_id']) && isset($order['id'])) {
            $order['order_id'] = $order['id'];
        }

        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);
    }

    public function index(Request $request)
    {
        $orders = $this->dataService->getOrders();
        $orders = collect($orders)->sortByDesc('created_at')->values()->all();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();
        Log::info('Webhook received:', $payload);

        if (isset($payload['order_id'])) {
            $orderId = $payload['order_id'];
            $status = $payload['transaction_status'] ?? 'PAID';
            $updated = $this->dataService->updateOrderStatus($orderId, $status);
            
            if ($updated) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Order status updated'
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Webhook processed'
        ]);
    }
}