<?php

use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrintedMarked extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('nominatives')
                ->whereColumn('nominatives.teacher_id', 'teachers.id');
        })->update(['printed' => true]);
    }
}
