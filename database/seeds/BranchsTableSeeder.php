<?php

use App\Imports\BranchsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class BranchsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new BranchsImport, storage_path('seeds/branchs.xlsx'));
    }
}
