<?php

use App\Models\Branch;
use App\Models\Nominative;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class RecapAllKCD extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nominatives = Nominative::all();

        foreach ($nominatives as $nominative) {
            $teacher = Teacher::find($nominative->teacher_id);

            if ($teacher && $teacher->verified === false) {
                $nominative->active = false;
            }

            if (!$teacher) {
                $nominative->active = false;
            }

            $nominative->save();
        }

        $results = [];

        $lebaks = Branch::find(1)->schools()->pluck('id');

        $c_lebak = Nominative::whereIn('school_id', $lebaks)->where('active', true)->count();

        $pandeglangs = Branch::find(2)->schools()->pluck('id');

        $c_pandeglang = Nominative::whereIn('school_id', $pandeglangs)->where('active', true)->count();

        $seragons = Branch::find(3)->schools()->pluck('id');

        $c_seragon = Nominative::whereIn('school_id', $seragons)->where('active', true)->count();

        $kabtangs = Branch::find(4)->schools()->pluck('id');

        $c_kabtang = Nominative::whereIn('school_id', $kabtangs)->where('active', true)->count();

        $kotangsels = Branch::find(5)->schools()->pluck('id');

        $c_kotangsel = Nominative::whereIn('school_id', $kotangsels)->where('active', true)->count();



        $results['lebak'] = $c_lebak;
        $results['pandeglang'] = $c_pandeglang;
        $results['seragon'] = $c_seragon;
        $results['kabtang'] = $c_kabtang;
        $results['kotangsel'] = $c_kotangsel;

        dd($results);
    }
}
