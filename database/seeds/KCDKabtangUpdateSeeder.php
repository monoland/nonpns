<?php

use App\Models\Branch;
use App\Models\Nominative;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class KCDKabtangUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branch = Branch::find(4);

        if ($branch) {
            $schools = $branch->schools;

            foreach ($schools as $school) {
                $nominatives  = Nominative::where('school_id', $school->id)->get();

                foreach ($nominatives as $nominative) {
                    $teacher = Teacher::find($nominative->teacher_id);

                    if ($teacher) {
                        $nominative->school_id = $teacher->school_id;
                        $nominative->subject = $teacher->subjects->pluck('name')->first();
                    } else {
                        $nominative->active = false;
                    }

                    $nominative->save();
                }
            }
        }
    }
}
