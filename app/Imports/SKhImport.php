<?php

namespace App\Imports;

use App\Models\Nominative;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SKhImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $nik = str_replace("'", "", $row['nik']);
        $teacher = Teacher::where('nik', $nik)->first();

        if ($teacher) {
            return new Nominative([
                'serial' => $row['serial'],
                'number' => $row['number'],
                'tmt' => Date::excelToDateTimeObject($row['tmt'])->format('Y-m-d'),
                'subject' => $row['subject'],
                'teacher_id' => $teacher->id,
                'school_id' => $teacher->school_id,
                'shorturl' => $this->generate()
            ]);
        } else {
            var_dump($row['serial'], $row['name']);
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function generate()
    {
        $characters = str_repeat('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 6);

        return substr(str_shuffle($characters), 0, 6);
    }
}
