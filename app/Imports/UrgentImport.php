<?php

namespace App\Imports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UrgentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $teachers = Teacher::all();

        foreach ($teachers as $teacher) {
            $teacher->register = str_replace(' ', '', trim($teacher->register));
            $teacher->save();
        }

        $nik = str_replace("'", "", $row['nik']);
        $rgs = str_replace("'", "", $row['register']);
        $teacher = Teacher::where('nik', $nik)->first();

        if ($teacher) {
            $teacher->register = str_replace("'", "", trim($rgs));
            $teacher->save();

            var_dump($rgs);
        }
    }
}
