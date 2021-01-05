<?php

namespace App\Exports;

use App\Models\Branch;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NominativeExport implements FromView
{
    protected $branch;

    public function __construct(Branch $branch)
    {
        $this->branch = $branch;
    }

    public function view(): View
    {
        return view('exports.nominatives', [
            'nominatives' => $this->branch->teachers()->where('verified', true)->where('printed', false)->orderBy('school_id')->get()
        ]);
    }
}
