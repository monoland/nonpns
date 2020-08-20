<?php

use App\Imports\SchoolTeacherImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class SchoolTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new SchoolTeacherImport, storage_path('seeds/school_teacher.xlsx'));
    }
}
