<?php

namespace App\Services\Data;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Excel;

class CsvExportService implements FromArray , WithCustomCsvSettings
{
    protected $data;

    public function __construct(array $data , array $header)
    {
        if ($header) {
            array_unshift($data, $header);
        }
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }


    public function getCsvSettings() : array
    {
        return [
            'delimiter' => ';',
            'enclosure' => '',
            'line_ending' => "\n",
        ];
    }
}