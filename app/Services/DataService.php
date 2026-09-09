<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DataService
{
    protected $productFile;
    protected $orderFile;
    protected $categoryFile;
    protected $shippingFile;

    public function __construct()
    {
        $this->productFile = storage_path('data/products.json');
        $this->orderFile = storage_path('data/orders.json');
        $this->categoryFile = storage_path('data/categories.json');
        $this->shippingFile = storage_path('data/shipping.json');
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

        return 50000; // Default Luar Jawa
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
}