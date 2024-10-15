<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MsCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('ms_categories')->insert([
            ['name' => 'Expense'],
            ['name' => 'Income'],
        ]);
    }
}
