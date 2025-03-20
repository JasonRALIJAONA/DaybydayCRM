<?php
namespace App\Services\Data;

use Illuminate\Support\Facades\DB;

class DataService
{
    function clearDataExcept (array $excludedTables = [])
    {
        // desactivation des cles etrangeres
        DB::statement('SET FOREIGN_KEY-CHEKS=0;');

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
        DB::statement('SET FOREIGN_KEY-CHEKS=1;');
    }
}