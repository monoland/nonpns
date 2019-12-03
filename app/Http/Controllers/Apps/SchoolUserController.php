<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class SchoolUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, School $school)
    {
        $this->authorize('viewAny', User::class);

        return new UserCollection(
            $school->users()->filterOn($request)->paginate($request->itemsPerPage)
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
        $this->authorize('create', User::class);

        $this->validate($request, [
            //
        ]);

        return User::storeRecord($request, $school);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $school
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(School $school, User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\School  $school
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school, User $user)
    {
        $this->authorize('update', $user);

        $this->validate($request, [
            //
        ]);

        return User::updateRecord($request, $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $school
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school, User $user)
    {
        $this->authorize('delete', $user);

        return User::destroyRecord($user);
    }

    /**
     * Remove the bulkdelete resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function bulkdelete(Request $request)
    {
        $this->authorize('bulkDelete', User::class);
        
        return User::bulkDelete($request);
    }

    /**
     * Display a listing for combo
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        return User::fetchCombo($request);
    }
}
