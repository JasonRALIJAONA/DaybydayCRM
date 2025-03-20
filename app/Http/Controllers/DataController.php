<?php

namespace App\Http\Controllers;

use App\Services\Data\DataService;
use Illuminate\Support\Facades\Log;

class DataController extends Controller
{
    public function getClear()
    {
        $excludedTables = explode(',', env('EXCLUDED_TABLE', ''));
        $list = env('EXCLUDED_TABLE', '');
        
        // Debugging: Log the excluded tables
        Log::info('Excluded Tables: ', $excludedTables);
        return view('data.clear');
    }

    public function clearData()
    {
        // take information from .env
        $excludedTables = explode(',', env('EXCLUDED_TABLE', ''));

        $dataService = new DataService();
        $dataService->clearDataExcept($excludedTables);
        Session()->flash('flash_message', __('Data cleared successfully!'));
        return redirect()->route('data.clear');
    }
}