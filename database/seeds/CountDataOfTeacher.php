<?php

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CounterTeacherExport;
use Illuminate\Database\Eloquent\Builder;

class CountDataOfTeacher extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $result = [];
        
        foreach (Branch::withCount([
            'teachers as verified_count' => function (Builder $query) {
                $query->where('verified', true)->where('printed', true);
            },

            'teachers as verified_pendidik' => function (Builder $query) {
                $query->where('verified', true)->where('printed', true)->where('status', 'Pendidik');
            },

            'teachers as verified_kependidikan' => function (Builder $query) {
                $query->where('verified', true)->where('printed', true)->where('status', 'Tenaga Kependidikan');
            },

            'teachers as dapodik_count' => function (Builder $query) {
                $query->where('verified', true)->where('printed', true)->where('dapodik', true);
            },

            'teachers as dapodik_pendidik' => function (Builder $query) {
                $query->where('verified', true)->where('printed', true)->where('dapodik', true)->where('status', 'Pendidik');
            },

            'teachers as dapodik_kependidikan' => function (Builder $query) {
                $query->where('verified', true)->where('printed', true)->where('dapodik', true)->where('status', 'Tenaga Kependidikan');
            }
        ])->get() as $branch) {
            array_push($result, [
                'name' => $branch->name,
                'verified_count' => $branch->verified_count,
                'verified_pendidik' => $branch->verified_pendidik,
                'verified_kependidikan' => $branch->verified_kependidikan,
                'dapodik_count' => $branch->dapodik_count,
                'dapodik_pendidik' => $branch->dapodik_pendidik,
                'dapodik_kependidikan' => $branch->dapodik_kependidikan,
            ]);

            foreach ($branch->cities()->withCount([
                'teachers as verified_count' => function (Builder $query) {
                    $query->where('verified', true)->where('printed', true);
                },
    
                'teachers as verified_pendidik' => function (Builder $query) {
                    $query->where('verified', true)->where('printed', true)->where('status', 'Pendidik');
                },
    
                'teachers as verified_kependidikan' => function (Builder $query) {
                    $query->where('verified', true)->where('printed', true)->where('status', 'Tenaga Kependidikan');
                },
    
                'teachers as dapodik_count' => function (Builder $query) {
                    $query->where('verified', true)->where('printed', true)->where('dapodik', true);
                },
    
                'teachers as dapodik_pendidik' => function (Builder $query) {
                    $query->where('verified', true)->where('printed', true)->where('dapodik', true)->where('status', 'Pendidik');
                },
    
                'teachers as dapodik_kependidikan' => function (Builder $query) {
                    $query->where('verified', true)->where('printed', true)->where('dapodik', true)->where('status', 'Tenaga Kependidikan');
                }
            ])->get() as $city) {
                array_push($result, [
                    'name' => $city->name,
                    'verified_count' => $city->verified_count,
                    'verified_pendidik' => $city->verified_pendidik,
                    'verified_kependidikan' => $city->verified_kependidikan,
                    'dapodik_count' => $city->dapodik_count,
                    'dapodik_pendidik' => $city->dapodik_pendidik,
                    'dapodik_kependidikan' => $city->dapodik_kependidikan,
                ]);
            }
        }

        dd(Excel::store(new CounterTeacherExport(collect($result)), 'results.xlsx'));
    }
}
