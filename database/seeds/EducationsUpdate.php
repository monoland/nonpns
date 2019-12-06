<?php

use App\Models\Education;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class EducationsUpdate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $education = new Education();
        $education->name = 'Tidak Sekolah';
        $education->slug = Str::slug('Tidak Sekolah');
        $education->save();
    }
}
