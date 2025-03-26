<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request; 
use App\Services\Data\DataService;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Services\Data\ClientService;
use App\Services\Data\CsvExporter;
use App\Services\Data\ImportService;
use Exception;
use Google\Service\Fitness\Session;
use Illuminate\Support\Facades\DB;

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
        $file1 = $request->file('file1');
        $filename1 = $file1->getPathname();


        $file2 = $request->file('file2');
        $filename2 = $file2->getPathname();

        $file3 = $request->file('file3');
        $filename3 = $file3->getPathname();
        $realFileName = $file3->getClientOriginalName();
        
        $importService = new ImportService();

        $error = [];

        try {
            DB::beginTransaction();
            $importService->importProjectAndClient($filename1);
            $importService->importTask($filename2);
            $error = $importService->importLeadProductInvoice($filename3 , $realFileName);

            if (!Empty($error)) {
                throw new Exception();
            }

            Log::info('Data imported successfully');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            // Log::error('Stack trace: ' . $e->getTraceAsString());
            Session()->flash('flash_message_warning', __('Error importing data!'));
            return view('data.import' , ['err' => $error]);
        }

        // $dataService->import_industry($filename);
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

    public function duplicateClient($id)
    {
        $clientService = new ClientService();
        // dd($id);
        $data = $clientService -> exportClientdata($id);
        $header = 
        [
            'client_id',
            'type',
            'id'
        ];

        return $this->csvExporter->export($data, $header, 'client.csv');
    }
}