<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DataService;

class ProductController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    public function index()
    {
        return view('products.index');
    }

    public function show($id)
    {
        $product = $this->dataService->getProductById($id);
        
        if (!$product) {
            abort(404);
        }
        
        return view('products.show', ['id' => $id, 'product' => $product]);
    }
}