<?php

use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixSchoolBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schools = School::all();

        foreach ($schools as $school) {
            DB::table('teachers')->where('school_id', $school->id)->update([
                'branch_id' => $school->branch_id, 'city_id' => $school->city_id
            ]);
        }
    }
}
