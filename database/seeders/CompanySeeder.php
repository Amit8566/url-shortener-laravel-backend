<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'name' => 'Tech Solutions Pvt Ltd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Digital Marketing Agency',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ABC Software Solutions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Global IT Services',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Creative Web Studio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}