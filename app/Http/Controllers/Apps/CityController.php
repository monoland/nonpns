<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityCollection;
use App\Models\Branch;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Branch $branch)
    {
        $this->authorize('viewAny', City::class);

        return new CityCollection(
            $branch->citys()->filterOn($request)->paginate($request->itemsPerPage)
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
        $this->authorize('create', City::class);

        $this->validate($request, [
            //
        ]);

        return City::storeRecord($request, $branch);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch, City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch, City $city)
    {
        $this->authorize('update', $city);

        $this->validate($request, [
            //
        ]);

        return City::updateRecord($request, $city);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch, City $city)
    {
        $this->authorize('delete', $city);

        return City::destroyRecord($city);
    }

    /**
     * Remove the bulkdelete resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function bulkdelete(Request $request)
    {
        $this->authorize('bulkDelete', City::class);

        return City::bulkDelete($request);
    }

    /**
     * Display a listing for combo
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        return City::fetchCombo($request);
    }
}
