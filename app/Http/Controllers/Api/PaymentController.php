<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Invoice\InvoiceCalculator;

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

    public function update($id)
    {
        // dd(request()->amount);

        $payment = Payment::where('id', $id)->first();
        $invoice = $payment->invoice;
        $invoiceCalculator = new InvoiceCalculator($invoice);
        $newAmountDue = $invoiceCalculator->getAmountDue()->getAmount() - (request()->amount * 100) + $payment->amount;

        if ($newAmountDue < 0) {
            return response()->json([
                'success' => false,
                'message' => 'The update exceeds the amount due',
            ], 200);
        }

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found',
            ], 200);
        }

        request()->merge(['amount' => request()->amount * 100]);
        $payment->update(request()->all());

        return response()->json([
            'success' => true,
            'message' => 'Payment updated',
        ], 200);
    }


    public function show($id)
    {
        $payment = Payment::where('id', $id)->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment data',
            'data' => $payment,
        ], 200);
    }
}