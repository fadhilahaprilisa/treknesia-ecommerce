<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DataService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * POST /api/orders
     * Buat pesanan baru (Guest Checkout)
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_whatsapp' => 'required|string|max:20',
            'customer_address' => 'required|string|max:255',
            'customer_city' => 'required|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // 2. Hitung total harga
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

            $subtotal = $product['price'] * $item['quantity'];
            $totalPrice += $subtotal;

            $orderItems[] = [
                'product_id' => $product['id'],
                'product_name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal
            ];
        }

        // 3. Hitung ongkir
        $shippingCost = $this->dataService->calculateShipping($validated['customer_city']);
        $totalAmount = $totalPrice + $shippingCost;

        // 4. Generate order ID
        $orderId = $this->dataService->generateOrderId();

        // 5. Buat data order
        $order = [
            'id' => $orderId,
            'customer_name' => $validated['customer_name'],
            'customer_whatsapp' => $validated['customer_whatsapp'],
            'customer_address' => $validated['customer_address'],
            'customer_city' => $validated['customer_city'],
            'items' => $orderItems,
            'total_price' => $totalPrice,
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
            'status' => 'PENDING',
            'payment' => null,
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString()
        ];

        // 6. Simpan order ke file JSON
        $this->dataService->saveOrder($order);

        // 7. Kirim response (nanti di Fase 5 akan ditambah payment token)
        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
            'data' => [
                'order_id' => $orderId,
                'total_amount' => $totalAmount,
                'status' => 'PENDING',
                'payment_url' => null, // Akan diisi di Fase 5
                'order' => $order
            ]
        ], 201);
    }

    /**
     * GET /api/orders/{id}
     * Cek status pesanan
     */
    public function show($id)
    {
        $order = $this->dataService->getOrderById($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'order_id' => $order['id'],
                'customer_name' => $order['customer_name'],
                'customer_whatsapp' => $order['customer_whatsapp'],
                'customer_address' => $order['customer_address'],
                'customer_city' => $order['customer_city'],
                'items' => $order['items'],
                'total_price' => $order['total_price'],
                'shipping_cost' => $order['shipping_cost'],
                'total_amount' => $order['total_amount'],
                'status' => $order['status'],
                'payment' => $order['payment'] ?? null,
                'created_at' => $order['created_at'],
                'updated_at' => $order['updated_at']
            ]
        ]);
    }

    /**
     * POST /api/webhook
     * Endpoint untuk notifikasi payment gateway
     */
    public function webhook(Request $request)
    {
        // Sementara kita buat sederhana dulu
        // Nanti di Fase 5 akan diisi dengan integrasi Midtrans/Xendit
        
        $payload = $request->all();
        
        // Log webhook
        \Log::info('Webhook received:', $payload);

        // Contoh: jika ada order_id di payload
        if (isset($payload['order_id'])) {
            $orderId = $payload['order_id'];
            $status = $payload['transaction_status'] ?? 'PAID';
            
            // Update status order
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

    /**
     * GET /api/orders (Admin only - untuk list semua order)
     * Tambahan untuk admin
     */
    public function index(Request $request)
    {
        $orders = $this->dataService->getOrders();
        
        // Sort by created_at descending (terbaru di atas)
        $orders = collect($orders)->sortByDesc('created_at')->values()->all();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }
}