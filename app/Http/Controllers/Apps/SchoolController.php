<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolCollection;
use App\Models\Branch;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Branch $branch)
    {
        $this->authorize('viewAny', School::class);

        return new SchoolCollection(
            $branch->schools()->filterOn($request)->paginate($request->itemsPerPage)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Branch $branch)
    {
        $this->authorize('create', School::class);

        $this->validate($request, [
            //
        ]);

        return School::storeRecord($request, $branch);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch, School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch, School $school)
    {
        $this->authorize('update', $school);

        $this->validate($request, [
            //
        ]);

        return School::updateRecord($request, $school);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch, School $school)
    {
        $this->authorize('delete', $school);

        return School::destroyRecord($school);
    }

    /**
     * Remove the bulkdelete resource from storage.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function bulkdelete(Request $request)
    {
        $this->authorize('bulkDelete', School::class);
        
        return School::bulkDelete($request);
    }

    /**
     * Display a listing for combo
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        return School::fetchCombo($request);
    }

    /**
     * Undocumented function
     *
     * @param School $school
     * @return void
     */
    public function resetPassword(School $school)
    {
        $school->user()->update([
            'email' => Str::slug($school->name, '_'),
            'password' => Hash::make('12345')
        ]);

        return $school->with('user');
    }
}
