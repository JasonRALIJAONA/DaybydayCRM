<?php

namespace App\Services\Data;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;

class ClientService
{
    function exportClientdata ($clientId)
    {
        $data = [];

        $projects = Project::where('client_id' , $clientId)->get();
        $invoices = Invoice::where('client_id' , $clientId)->get();

        foreach ($projects as $project) {
            $data[] = [$clientId , 'project' , $project->id];
        }

        foreach ($invoices as $invoice) {
            $data[] = [$clientId , 'invoice' , $invoice->id];
        }

        return  $data;
    }
}