<?php

use App\Imports\SubjectsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new SubjectsImport, storage_path('seeds/subjects.xlsx'));
    }
}
