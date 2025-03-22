<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPayment  = Payment::sum('amount');
        $totalTask = Task::count();
        $totalOffer = Offer::count();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard data',
            'data' => [
                'totalPayment' => $totalPayment,
                'totalTask' => $totalTask,
                'totalOffer' => $totalOffer,
            ],
        ], 200);
    }
}