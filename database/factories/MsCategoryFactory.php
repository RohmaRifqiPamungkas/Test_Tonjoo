<?php

namespace Database\Factories;

use App\Models\MsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MsCategoryFactory extends Factory
{
    protected $model = MsCategory::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(), 
        ];
    }
}
