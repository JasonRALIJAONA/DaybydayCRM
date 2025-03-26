<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InvoiceLine;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoiceLines = InvoiceLine::all();

        return response()->json([
            'success' => true,
            'message' => 'Task data',
            'data' => $invoiceLines,
        ], 200);
    }
}