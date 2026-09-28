<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DataService;

class InvoiceController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    public function show($id)
    {
        $order = $this->dataService->getOrderById($id);
        
        if (!$order) {
            abort(404, 'Pesanan tidak ditemukan');
        }
        
        return view('invoice.show', [
            'id' => $id,
            'order' => $order
        ]);
    }
}