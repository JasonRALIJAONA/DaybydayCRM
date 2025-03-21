<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
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

    public function getImport()
    {
        return view('data.import');    
    }

    public function importData(Request $request)
    {
        // Get the uploaded file
        $file = $request->file('file');

        // Get the original filename
        $filename = $file->getPathname();

        // Move the file to a specific directory within storage/app/import
        // $path = $file->storeAs('import', $filename);

        // // Get the full path to the stored file
        // $fullPath = storage_path('app/' . $path);
        
        $dataService = new DataService();
        $dataService->import_industry($filename);
        Session()->flash('flash_message', __('Data imported successfully!'));
        return redirect()->route('data.import');
    }
}