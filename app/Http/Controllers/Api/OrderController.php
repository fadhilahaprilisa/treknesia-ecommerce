<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DataService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    public function store(Request $request)
    {
        // Akan diisi di Fase 2
        return response()->json([
            'status' => 'success',
            'message' => 'Order created'
        ]);
    }

    public function show($id)
    {
        // Akan diisi di Fase 2
        return response()->json([
            'status' => 'success',
            'data' => ['id' => $id, 'status' => 'PENDING']
        ]);
    }

    public function webhook(Request $request)
    {
        // Akan diisi di Fase 2
        return response()->json([
            'status' => 'success',
            'message' => 'Webhook received'
        ]);
    }
}