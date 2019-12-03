<?php

use App\Imports\CitiesImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new CitiesImport, storage_path('seeds/cities.xlsx'));
    }
}
