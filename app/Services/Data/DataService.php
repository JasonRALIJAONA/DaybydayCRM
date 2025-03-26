<?php
namespace App\Services\Data;

use Illuminate\Support\Facades\DB;
use App\Models\Industry;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;

class DataService
{
    function clearDataExcept (array $excludedTables = [])
    {
        // desactivation des cles etrangeres
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // recuperer tous les tables
        $tables = DB::select ('SHOW TABLES');

        // recuperer le nom de la base de donnees
        $databasename =env('DB_DATABASE');

        // trouver dynamiquement la cle correcte
        $tablekey = 'Tables_in_'.$databasename;

        foreach ($tables as $table) {
            // verifier si la cle existe bien
            if (!isset($table->$tablekey)) {
                continue;
            }

            $tablename = $table->$tablekey;

            // verifier si la table est exclue
            if (!in_array($tablename, $excludedTables)) {
                DB::table($tablename)->truncate();
            }
        }

        // reactivation des cles etrangeres
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
  
    function clearData()
    {
        Log::info('clearData function called');

        Log::info('Starting migrate:fresh');
        $output = shell_exec('cd ' . base_path() . ' && php artisan migrate:fresh --seed 2>&1');
        Log::info('Finished migrate:fresh', ['output' => $output]);

        // Check for errors
        if (strpos($output, 'SQLSTATE') !== false) {
            Log::error('Error during migrate:fresh', ['output' => $output]);
        }

        Log::info('clearData function completed');
    }

    function import_industry($filename) 
    {
        Log::info('Importing industry data from file: ' . $filename);

        // Open the CSV file
        if (($handle = fopen($filename, 'r')) !== false) {
            // Read the header row
            $header = fgetcsv($handle, 1000, ';');

            // Loop through the file line by line
            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                // Create an associative array with the header as keys
                $row = array_combine($header, $data);

                // Insert the data into the industries table
                Industry::create([
                    'external_id' => $row['external_id'],
                    'name' => $row['name'],
                ]);
            }

            // Close the file
            fclose($handle);
        }
    }

    public function resetAndSeedDatabase()
    {
        // Log::info('Starting migrate:fresh');
        // exec('php artisan migrate:fresh --seed', $output1);
        // Log::info('Finished migrate:fresh', $output1);

        Log::info('Starting DummyDatabaseSeeder');
        Artisan::call('db:seed', ['--class' => 'DummyDatabaseSeeder']);
        Log::info('Finished DummyDatabaseSeeder');
    }

    function import_client()
    {
        Log::info('Importing industry data from file: ');
        $filename = "C:\upload\client.csv";
        // Open the CSV file
        if (($handle = fopen($filename, 'r')) !== false) {
            // Read the header row
            $header = fgetcsv($handle, 1000, ',');

            // Loop through the file line by line
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                // Create an associative array with the header as keys
                $row = array_combine($header, $data);

                $oldClient = Client::where('id' , $row['client_id'])->get()->first();
                // $name = $oldClient['company_name'];
                $copyname = $oldClient->company_name." copy ";
                // Insert the data into the industries table
                $projects = Project::where('client_id' , $row['client_id'])->get();
                $invoices = Invoice::where('client_id' , $row['client_id'])->get();

                // dd($copyname);
                $client = Client::firstOrCreate(
                    ['company_name' => $copyname],
                    ['external_id' => $oldClient->external_id,
                    'address' => $oldClient->address,
                    'zipcode' => $oldClient->postcode,
                    'city' => $oldClient->city,
                    'company_type' => 'ApS',
                    'industry_id' => $oldClient->industry_id,
                    'user_id' => $oldClient->user_id,
                ]);

                foreach ($projects as $project) {
                    $project->client_id = $client->id;
                    $project->save();
                }

                foreach ($invoices as $invoice) {
                    $invoice->client_id = $client->id;
                    $invoice->save();
                }

                break;
            }

            // Close the file
            fclose($handle);
        }
    }
}