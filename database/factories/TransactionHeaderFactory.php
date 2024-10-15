<?php

namespace Database\Factories;

use App\Models\TransactionHeader;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionHeaderFactory extends Factory
{
    protected $model = TransactionHeader::class;

    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'code' => $this->faker->unique()->numerify('TRX###'),
            'rate_euro' => $this->faker->randomFloat(2, 10, 20),
            'date_paid' => $this->faker->dateTimeThisYear,
        ];
    }
}
