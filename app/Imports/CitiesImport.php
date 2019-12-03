<?php

namespace App\Imports;

use App\Models\City;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CitiesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new City([
            'name' => $row['name'],
            'slug' => Str::slug($row['name']),
            'branch_id' => $row['branch_id']
        ]);
    }
}
