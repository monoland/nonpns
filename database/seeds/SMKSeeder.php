<?php

use App\Imports\SMKImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class SMKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new SMKImport, storage_path('seeds/smk.xlsx'));
    }
}
