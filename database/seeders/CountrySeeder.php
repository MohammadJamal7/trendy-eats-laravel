<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            ['name' => 'United States'],
            ['name' => 'Canada'],
            ['name' => 'Mexico'],
            ['name' => 'Brazil'],
            ['name' => 'United Kingdom'],
            ['name' => 'France'],
            ['name' => 'Germany'],
            ['name' => 'Japan'],
            ['name' => 'Australia'],
            ['name' => 'India'],
        ]);
    }
}
