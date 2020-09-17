<?php

use App\Imports\UrgentImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class UrgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new UrgentImport, storage_path('seeds/nuptk.xlsx'));
    }
}
