<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index()
    {
        $offer = Offer::all();

        return response()->json([
            'success' => true,
            'message' => 'Offer data',
            'data' => $offer,
        ], 200);
    }
}