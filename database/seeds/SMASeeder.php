<?php

use App\Imports\SMAImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class SMASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new SMAImport, storage_path('seeds/sma.xlsx'));
    }
}
