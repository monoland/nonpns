<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SchoolTeacherImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            DB::table('school_teacher')->where('id', intval($row['id']))->update([
                'school_id' => intval($row['school_id']),
                'teacher_id' => intval($row['teacher_id']),
            ]);
        }
    }
}
