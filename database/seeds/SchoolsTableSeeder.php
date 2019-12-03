<?php

use App\Imports\SchoolsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new SchoolsImport, storage_path('seeds/schools.xlsx'));
    }
}
