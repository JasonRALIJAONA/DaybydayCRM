<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payment = Payment::all();

        return response()->json([
            'success' => true,
            'message' => 'Payment data',
            'data' => $payment,
        ], 200);
    }

    public function delete($id)
    {
        $payment = Payment::where('id', $id)->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found',
            ], 200);
        }

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment deleted',
        ], 200);
        
    }
}