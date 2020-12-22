<?php

namespace App\Imports;

use App\Models\Teacher;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DapodikImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $nik = substr($row['nik'], 3);

            if ($row['status_tugas'] !== 'Induk' && strlen($nik) < 5) {
                continue;
            }

            if ($teacher = Teacher::firstWhere('nik', $nik)) {
                var_dump($nik);
                
                $teacher->dapodik = true;
                $teacher->save();
            }
        }
    }
}
