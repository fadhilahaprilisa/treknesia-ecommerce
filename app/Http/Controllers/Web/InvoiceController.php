<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function show($id)
    {
        return view('invoice.show', ['id' => $id]);
    }
}