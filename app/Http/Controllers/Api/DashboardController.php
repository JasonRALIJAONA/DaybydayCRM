<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPayment  = Payment::sum('amount');
        $totalTask = Task::count();
        $totalOffer = Offer::count();
        $tasks = Task::all()->toArray();
        $offers = Offer::all()->toArray();
        $invoices = Invoice::all()->toArray();
        $totalInvoice = Invoice::count();

        $totalInvoicePrice = DB::select("SELECT sum(price * quantity) as amount FROM invoice_lines WHERE invoice_id IS NOT NULL")[0]->amount;


        return response()->json([
            'success' => true,
            'message' => 'Dashboard data',
            'data' => [
                'totalPayment' => $totalPayment,
                'totalTask' => $totalTask,
                'totalOffer' => $totalOffer,
                'totalInvoice' =>$totalInvoice,
                'totalInvoicePrice' => $totalInvoicePrice,
                'tasks' => $tasks,
                'offers' => $offers,
                'invoices' => $invoices,
            ],
        ], 200);
    }
}