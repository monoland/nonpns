<?php

namespace App\Exports;

use App\Models\Teacher;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TeacherExport implements FromView
{
    public function view(): View
    {
        return view('exports.teachers', [
            'teachers' => Teacher::with('subject')->where('city_id', env('OUTPUT_MAP', 1))->where('verified', true)->orderBy('school_id')->orderBy('name')->get()
        ]);
    }
}
