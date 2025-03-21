<?php
namespace App\Services\Data;

use Illuminate\Support\Facades\DB;
use App\Models\Industry;
use Illuminate\Support\Facades\Log;
use App\Models\User;

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
}