<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class DataService
{
    protected $productFile;
    protected $orderFile;
    protected $categoryFile;
    protected $shippingFile;
    protected $userFile;

    public function __construct()
    {
        $this->productFile = storage_path('data/products.json');
        $this->orderFile = storage_path('data/orders.json');
        $this->categoryFile = storage_path('data/categories.json');
        $this->shippingFile = storage_path('data/shipping.json');
        $this->userFile = storage_path('data/users.json');
    }

    // ============ PRODUCT METHODS ============
    public function getProducts()
    {
        if (!File::exists($this->productFile)) {
            return [];
        }
        return json_decode(File::get($this->productFile), true) ?? [];
    }

    public function getProductById($id)
    {
        $products = $this->getProducts();
        return collect($products)->firstWhere('id', (int)$id);
    }

    public function getProductsByCategory($category)
    {
        $products = $this->getProducts();
        return collect($products)->where('category', $category)->values()->all();
    }

    public function getProductsByGender($gender)
    {
        $products = $this->getProducts();
        return collect($products)->where('gender', $gender)->values()->all();
    }

    // ============ CATEGORY METHODS ============
    public function getCategories()
    {
        if (!File::exists($this->categoryFile)) {
            return [];
        }
        return json_decode(File::get($this->categoryFile), true) ?? [];
    }

    // ============ SHIPPING METHODS ============
    public function getShippingZones()
    {
        if (!File::exists($this->shippingFile)) {
            return ['zones' => []];
        }
        return json_decode(File::get($this->shippingFile), true) ?? [];
    }

    public function calculateShipping($city)
    {
        $zones = $this->getShippingZones();
        $zones = $zones['zones'] ?? [];

        foreach ($zones as $zone) {
            if (in_array($city, $zone['cities'])) {
                return $zone['cost'];
            }
        }

        return 50000;
    }

    // ============ ORDER METHODS ============
    public function getOrders()
    {
        if (!File::exists($this->orderFile)) {
            return [];
        }
        return json_decode(File::get($this->orderFile), true) ?? [];
    }

    public function getOrderById($id)
    {
        $orders = $this->getOrders();
        return collect($orders)->firstWhere('id', $id);
    }

    public function saveOrder($order)
    {
        $orders = $this->getOrders();
        $orders[] = $order;
        File::put($this->orderFile, json_encode($orders, JSON_PRETTY_PRINT));
        return $order;
    }

    public function updateOrderStatus($id, $status)
    {
        $orders = $this->getOrders();
        $index = collect($orders)->search(function ($order) use ($id) {
            return $order['id'] === $id;
        });

        if ($index !== false) {
            $orders[$index]['status'] = $status;
            $orders[$index]['updated_at'] = now()->toDateTimeString();
            File::put($this->orderFile, json_encode($orders, JSON_PRETTY_PRINT));
            return true;
        }

        return false;
    }

    public function updateOrderPayment($id, $paymentData)
    {
        $orders = $this->getOrders();
        $index = collect($orders)->search(function ($order) use ($id) {
            return $order['id'] === $id;
        });

        if ($index !== false) {
            $orders[$index]['payment'] = $paymentData;
            $orders[$index]['updated_at'] = now()->toDateTimeString();
            File::put($this->orderFile, json_encode($orders, JSON_PRETTY_PRINT));
            return true;
        }

        return false;
    }

    // ============ PRODUCT CRUD (ADMIN) ============
    public function addProduct($data)
    {
        $products = $this->getProducts();
        
        $maxId = collect($products)->max('id') ?? 0;
        $data['id'] = $maxId + 1;
        
        $products[] = $data;
        File::put($this->productFile, json_encode($products, JSON_PRETTY_PRINT));
        return $data;
    }

    public function updateProduct($id, $data)
    {
        $products = $this->getProducts();
        $index = collect($products)->search(fn($p) => $p['id'] === (int)$id);
        
        if ($index !== false) {
            $products[$index] = array_merge($products[$index], $data);
            File::put($this->productFile, json_encode($products, JSON_PRETTY_PRINT));
            return true;
        }
        return false;
    }

    public function deleteProduct($id)
    {
        $products = $this->getProducts();
        $filtered = collect($products)->reject(fn($p) => $p['id'] === (int)$id)->values()->all();
        
        if (count($filtered) < count($products)) {
            File::put($this->productFile, json_encode($filtered, JSON_PRETTY_PRINT));
            return true;
        }
        return false;
    }

    // ============ PAYMENT VERIFICATION ============
    
    /**
     * ✅ FIXED (Opsi C): Upload bukti bayar → status utama langsung PAID
     */
    public function uploadPaymentProof($id, $proofData)
    {
        $orders = $this->getOrders();
        $index = collect($orders)->search(fn($o) => $o['id'] === $id);
        
        if ($index !== false) {
            $orders[$index]['payment_proof'] = $proofData;
            $orders[$index]['payment_status'] = 'VERIFIED';      // ✅ Langsung VERIFIED
            $orders[$index]['status'] = 'PAID';                  // ✅ Status utama jadi PAID
            $orders[$index]['updated_at'] = now()->toDateTimeString();
            File::put($this->orderFile, json_encode($orders, JSON_PRETTY_PRINT));
            return true;
        }
        return false;
    }

    /**
     * Admin verifikasi manual (untuk COD atau reject)
     */
    public function verifyPayment($id, $status, $note = null)
    {
        $orders = $this->getOrders();
        $index = collect($orders)->search(fn($o) => $o['id'] === $id);
        
        if ($index !== false) {
            $orders[$index]['payment_status'] = $status;
            $orders[$index]['payment_note'] = $note;
            if ($status === 'VERIFIED') {
                $orders[$index]['status'] = 'PAID';
            }
            $orders[$index]['updated_at'] = now()->toDateTimeString();
            File::put($this->orderFile, json_encode($orders, JSON_PRETTY_PRINT));
            return true;
        }
        return false;
    }

    public function generateOrderId()
    {
        $orders = $this->getOrders();
        $count = count($orders) + 1;
        return 'TRK-' . str_pad($count, 6, '0', STR_PAD_LEFT);
    }

    // ============ BRAND METHODS ============
    public function getBrands()
    {
        $products = $this->getProducts();
        $brands = collect($products)->pluck('brand')->filter()->unique()->values()->all();
        return $brands;
    }

    public function getProductsByBrand($brand)
    {
        $products = $this->getProducts();
        return collect($products)->where('brand', $brand)->values()->all();
    }

    // ============ USER METHODS ============
    public function getUsers()
    {
        if (!File::exists($this->userFile)) {
            return [];
        }
        return json_decode(File::get($this->userFile), true) ?? [];
    }

    public function getUserByEmail($email)
    {
        $users = $this->getUsers();
        return collect($users)->firstWhere('email', $email);
    }

    public function getUserById($id)
    {
        $users = $this->getUsers();
        return collect($users)->firstWhere('id', (int)$id);
    }

    public function saveUser($user)
    {
        $users = $this->getUsers();
        
        $maxId = collect($users)->max('id') ?? 0;
        $user['id'] = $maxId + 1;
        $user['created_at'] = now()->toDateTimeString();
        
        $users[] = $user;
        File::put($this->userFile, json_encode($users, JSON_PRETTY_PRINT));
        return $user;
    }

    public function updateUser($id, $data)
    {
        $users = $this->getUsers();
        $index = collect($users)->search(fn($u) => $u['id'] === (int)$id);
        
        if ($index !== false) {
            $users[$index] = array_merge($users[$index], $data);
            File::put($this->userFile, json_encode($users, JSON_PRETTY_PRINT));
            return true;
        }
        return false;
    }
}