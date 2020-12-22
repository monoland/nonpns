<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class CounterTeacherExport implements FromCollection
{
    protected $results;
    
    public function __construct($results)
    {
        $this->results = $results;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->results;
    }
}
