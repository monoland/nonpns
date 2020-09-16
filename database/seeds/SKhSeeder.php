<?php

use App\Imports\SKhImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class SKhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new SKhImport, storage_path('seeds/nominatives.xlsx'));
    }
}
