<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherCollection;
use App\Http\Resources\TeacherResource;
use App\Models\School;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, School $school)
    {
        $this->authorize('viewAny', Teacher::class);

        return new TeacherCollection(
            $school->teachers()->filterOn($request)->paginate($request->itemsPerPage)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, School $school)
    {
        $this->authorize('create', Teacher::class);

        $this->validate($request, [
            //
        ]);

        return Teacher::storeRecord($request, $school);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $school
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(School $school, Teacher $teacher)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\School  $school
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school, Teacher $teacher)
    {
        $this->authorize('update', $teacher);

        $this->validate($request, [
            //
        ]);

        return Teacher::updateRecord($request, $teacher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $school
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school, Teacher $teacher)
    {
        $this->authorize('delete', $teacher);

        return Teacher::destroyRecord($teacher);
    }

    /**
     * Remove the bulkdelete resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function bulkdelete(Request $request)
    {
        $this->authorize('bulkDelete', Teacher::class);
        
        return Teacher::bulkDelete($request);
    }

    /**
     * Display a listing for combo
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        return Teacher::fetchCombo($request);
    }
}
