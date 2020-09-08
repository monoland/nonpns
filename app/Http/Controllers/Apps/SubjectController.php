<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Resources\RequirementReport;
use App\Http\Resources\SubjectCollection;
use App\Models\Branch;
use App\Models\Requirement;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Subject::class);

        return new SubjectCollection(
            Subject::filterOn($request)->paginate($request->itemsPerPage)
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
        $this->authorize('create', Subject::class);

        $this->validate($request, [
            //
        ]);

        return Subject::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $this->authorize('update', $subject);

        $this->validate($request, [
            //
        ]);

        return Subject::updateRecord($request, $subject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $this->authorize('delete', $subject);

        return Subject::destroyRecord($subject);
    }

    /**
     * Remove the bulkdelete resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function bulkdelete(Request $request)
    {
        $this->authorize('bulkDelete', Subject::class);

        return Subject::bulkDelete($request);
    }

    /**
     * Display a listing for combo
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        return Subject::fetchCombo($request);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function reports(Request $request)
    {
        $schools = Branch::find(5)->schools()->select('id')->get();

        return RequirementReport::collection(
            Requirement::select(
                'subject_id',
                DB::raw('SUM(require) as require'),
                DB::raw('SUM(available) as available'),
                DB::raw('SUM(honorer) as honorer'),
                DB::raw('SUM(balance) as balance'),
            )->groupBy('subject_id')->whereIn('school_id', $schools->pluck('id'))->get()
        );
    }
}
