<?php

namespace App\Services\Data;

use Maatwebsite\Excel\Facades\Excel;

class CsvExporter
{
    public function export($data, $header, $filename)
    {
        return Excel::download(new CsvExportService($data, $header), $filename);
    }
}