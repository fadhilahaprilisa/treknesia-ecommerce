<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DataService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    public function index(Request $request)
    {
        $products = $this->dataService->getProducts();
        
        // Filter by category
        if ($request->has('category')) {
            $products = collect($products)
                ->where('category', $request->category)
                ->values()
                ->all();
        }

        // Filter by gender
        if ($request->has('gender')) {
            $products = collect($products)
                ->where('gender', $request->gender)
                ->values()
                ->all();
        }

        // Search
        if ($request->has('search')) {
            $search = strtolower($request->search);
            $products = collect($products)
                ->filter(function ($product) use ($search) {
                    return str_contains(strtolower($product['name']), $search) ||
                           str_contains(strtolower($product['description']), $search);
                })
                ->values()
                ->all();
        }

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    public function show($id)
    {
        $product = $this->dataService->getProductById($id);
        
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }
}