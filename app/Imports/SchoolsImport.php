<?php

namespace App\Imports;

use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SchoolsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $name = $row['name'];
        $xname = Str::slug($row['name'], '_');

        $school = School::create([
            'name' => $row['name'],
            'slug' => Str::slug($row['name']),
            'branch_id' => $row['branch_id'],
            'city_id' => $row['city_id'],
            'type' => $row['type']
        ]);

        $user = new User([
            'name' => $name,
            'email' => $xname,
            'password' => Hash::make('12345'),
            'authent_id' => 2,
        ]);

        $school->user()->save($user);

        return $school;
    }
}
