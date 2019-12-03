<?php

namespace App\Imports;

use App\Models\School;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TeachersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try {
            $school = School::where('slug', Str::slug($row['school']))->first();

            $born_date = $row['born_date'] ? Date::excelToDateTimeObject($row['born_date'])->format('Y-m-d') : null;
            $tmt_date = $row['tmt'] ? Date::excelToDateTimeObject($row['tmt'])->format('Y-m-d') : null;
            
            $teacher = Teacher::create([
                'front_title' => $row['front_title'],
                'name' => trim($row['name']),
                'back_title' => $row['back_title'],
                'gender' => trim(strtoupper($row['gender'])),
                'born_place' => $row['born_place'],
                'born_date' => $born_date,
                'status' => trim($row['status']),
                'tmt' => $tmt_date,
                'education_id' => $row['education_id'],
                'register' => $row['register'],
                'school_id' => $school->id,
                'branch_id' => $row['branch_id'],
                'city_id' => $row['city_id'],
            ]);

            $teacher->schools()->attach($school->id, ['mandatory' => true]);

            return $teacher;
        } catch (\Throwable $th) {
            dd($row);
        }
    }
}
