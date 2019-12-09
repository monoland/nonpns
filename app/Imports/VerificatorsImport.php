<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Verificator;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VerificatorsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $verificator = Verificator::create([
            'nip' => $row['nip'],
            'name' => $row['name'],
            'slug' => Str::slug($row['name']),
        ]);

        $user = new User([
            'name' => $row['name'],
            'email' => $row['nip'],
            'password' => Hash::make('54321'),
            'authent_id' => 3,
        ]);

        $verificator->user()->save($user);
    }
}
