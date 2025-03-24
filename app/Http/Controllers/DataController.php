<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Services\Data\DataService;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Services\Data\CsvExporter;


class DataController extends Controller
{
    private $csvExporter;

    public function __construct(CsvExporter $csvExporter)
    {
        $this->csvExporter = $csvExporter;
    }

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
        // $dataService->clearData();
        Session()->flash('flash_message', __('Data cleared successfully!'));
        return redirect()->route('data.clear');
    }

    public function generateData()
    {
        $dataService = new DataService();
        $dataService->resetAndSeedDatabase();
        Session()->flash('flash_message', __('Data generated successfully!'));
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

    public function getExport()
    {
        return view('data.export');
    }

    public function exportData()
    {
        $data = User::all(['name' , 'email', 'address' , 'created_at'])->toArray();
        // dd($data);

        $header = [
            'name',
            'email',
            'address',
            'created_at',
            'avatar'
        ];

        // Session()->flash('flash_message', __('Data exported successfully!'));
        return $this->csvExporter->export($data, $header, 'export.csv');
    }   
}