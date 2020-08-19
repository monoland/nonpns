<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Resources\RequirementCollection;
use App\Models\Requirement;
use App\Models\School;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Requirement::class);

        return new RequirementCollection(
            School::find($request->user()->userable->id)->requirements()->filterOn($request)->paginate(1000)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Requirement::class);

        $this->validate($request, [
            'require' => 'required|integer',
            'available' => 'required|integer'
        ]);

        // return Requirement::storeRecord($request, School::find($request->user()->userable->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function show(Requirement $requirement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requirement $requirement)
    {
        $this->authorize('update', $requirement);

        $this->validate($request, [
            'require' => 'required|integer',
            'available' => 'required|integer'
        ]);

        // return Requirement::updateRecord($request, $requirement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requirement $requirement)
    {
        $this->authorize('delete', $requirement);

        // return Requirement::destroyRecord($requirement);
    }

    /**
     * Remove the bulkdelete resource from storage.
     *
     * @param  \App\Models\Requirement  $requirement
     * @return \Illuminate\Http\Response
     */
    public function bulkdelete(Request $request)
    {
        $this->authorize('bulkDelete', Requirement::class);

        // return Requirement::bulkDelete($request);
    }

    /**
     * Display a listing for combo
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        return Requirement::fetchCombo($request);
    }
}
