<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrintTeacherCollection;
use App\Models\Branch;

class BranchTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function index(Branch $branch)
    {
        return new PrintTeacherCollection(
            $branch->teachers()->with(['education', 'subjects', 'school', 'city'])->where('verified', true)->get()
        );
    }
}
