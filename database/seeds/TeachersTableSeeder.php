<?php

use App\Imports\TeachersImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new TeachersImport, storage_path('seeds/teachers.xlsx'));
    }
}
