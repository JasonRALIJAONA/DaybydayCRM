<?php

use Illuminate\Database\Seeder;
use App\Models\Offer;
use App\Models\Invoice;
use App\Models\Payment;

class DummyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UsersDummyTableSeeder');
        $this->call('ClientsDummyTableSeeder');
        $this->call('TasksDummyTableSeeder');
        $this->call('LeadsDummyTableSeeder');
        // $this->call(InvoiceSeeder::class); // Register the InvoiceSeeder
        // $this->call(PaymentSeeder::class); 

        factory(Offer::class,20)->create();
        factory(Invoice::class,20)->create();
        factory(Payment::class,35)->create();
    }
}
