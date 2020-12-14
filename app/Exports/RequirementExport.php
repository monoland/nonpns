<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RequirementExport implements FromView
{
    protected $schools;

    public function __construct($schools)
    {
        $this->schools = $schools;
    }

    public function view(): View
    {
        return view('exports.requirements', [
            'schools' => $this->schools
        ]);
    }
}
