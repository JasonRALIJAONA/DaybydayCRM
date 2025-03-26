<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Invoice;
use Faker\Generator as Faker;
use App\Models\Client;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'external_id' => $faker->uuid,
        'status' => $faker->randomElement(['draft', 'closed' , 'sent' , 'unpaid' , 'partial_paid' , 'paid' , 'overpaid']),
        'client_id' => function () {
            return Client::inRandomOrder()->value('id') ?? factory(Client::class)->create()->id;
        },
        'sent_at' => $faker->dateTime,
        'due_at' => $faker->dateTime,
    ];
});
