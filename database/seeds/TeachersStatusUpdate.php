<?php

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeachersStatusUpdate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::withCount('documents')->chunk(200, function($teachers) {
            foreach ($teachers as $teacher) {
                if (!$teacher->updated) {
                    $teacher->updated = $teacher->documents_count > 0;
                    $teacher->save();
                }
            }
        });
    }
}
