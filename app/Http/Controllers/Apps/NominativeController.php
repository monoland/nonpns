<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Resources\NominativeCollection;
use App\Models\School;

class NominativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function index(School $school)
    {
        return new NominativeCollection($school->nominatives);
    }
}
