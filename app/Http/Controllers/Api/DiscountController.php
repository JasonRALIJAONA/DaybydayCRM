<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Payment;

class DiscountController extends Controller
{
    public function update($id)
    {
        $discount = Discount::where('id', $id)->first();

        if (!$discount) {
            return response()->json([
                'success' => false,
                'message' => 'Discount not found',
            ], 200);
        }

        $discount->update(request()->all());

        return response()->json([
            'success' => true,
            'message' => 'Discount updated',
        ], 200);
    }


    public function show($id)
    {
        $discount = Discount::where('id', $id)->first();

        if (!$discount) {
            return response()->json([
                'success' => false,
                'message' => 'Discount not found',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Discount data',
            'data' => $discount,
        ], 200);
    }
}