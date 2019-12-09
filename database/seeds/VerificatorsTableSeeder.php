<?php

use App\Imports\VerificatorsImport;
use App\Models\Authent;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class VerificatorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Authent::firstOrCreate(['name' => 'verificator']);

        Excel::import(new VerificatorsImport, storage_path('seeds/verificators.xlsx'));
    }
}
