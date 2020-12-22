<?php

use App\Imports\DapodikImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class DapodikExistingCheck extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = File::files(database_path('excels'));

        foreach ($files as $file) {
            var_dump($file->getFilenameWithoutExtension());
            
            Excel::import(new DapodikImport, $file->getPathname());
        }
    }
}
