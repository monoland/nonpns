<?php

namespace App\Http\Controllers\Apps;

use App\Exports\RequirementExport;
use App\Exports\TeacherExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchCollection;
use App\Http\Resources\BranchReports;
use App\Http\Resources\NominativeCollection;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Branch::class);

        return new BranchCollection(
            Branch::withCount([
                'schools',
                'schools as sma_count' => function (Builder $query) {
                    $query->where('type', 'sma');
                },
                'schools as smk_count' => function (Builder $query) {
                    $query->where('type', 'smk');
                },
                'schools as skh_count' => function (Builder $query) {
                    $query->where('type', 'skh');
                },
                'teachers',
                'teachers as updates_count' => function (Builder $query) {
                    $query->where('updated', true);
                },
                'teachers as verifies_count' => function (Builder $query) {
                    $query->where('verified', true);
                }
            ])->filterOn($request)->paginate($request->itemsPerPage)
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
        $this->authorize('create', Branch::class);

        $this->validate($request, [
            //
        ]);

        return Branch::storeRecord($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $this->authorize('update', $branch);

        $this->validate($request, [
            //
        ]);

        return Branch::updateRecord($request, $branch);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $this->authorize('delete', $branch);

        return Branch::destroyRecord($branch);
    }

    /**
     * Remove the bulkdelete resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function bulkdelete(Request $request)
    {
        $this->authorize('bulkDelete', Branch::class);

        return Branch::bulkDelete($request);
    }

    /**
     * Display a listing for combo
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function combo(Request $request)
    {
        return Branch::fetchCombo($request);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Branch $branch
     */
    public function reports(Request $request, Branch $branch)
    {
        // return $branch->schools;
        // return BranchReports::collection($branch->schools);
        Excel::store(new RequirementExport($branch->schools), $branch->name . '.xlsx');

        foreach ($branch->schools as $school) {
            if ($school->balance > 0) {
                dd($school);
            }
        }
    }

    public function receipt(Branch $branch)
    {
        $selection = [5211, 246, 331, 530, 3916, 3981, 8361, 6609, 722, 4057, 7894, 8052, 993, 1036, 8407, 3831, 1137, 1076, 1258, 1202, 8373, 7207, 2741, 1499, 1799, 1844, 7558, 1934, 2005, 8618, 2131, 2295, 2294, 2270, 6302, 3786, 2455, 2611, 906, 8610, 3008, 3056, 3018, 3059, 3086, 4067, 3185, 7715, 2904, 3419, 3444, 4255, 120, 6772, 3738, 3732, 3865, 3904, 3864, 3945, 3901, 6252, 3975, 3978, 4062, 3987, 4035, 4101, 3986, 4158, 4152, 4194, 4203, 4204, 3205, 4339, 4337, 4309, 4310, 4416, 4421, 4448, 4465, 4500, 8410, 4598, 4639, 4648, 4683, 8269, 4814, 4985, 4578, 1253, 5198, 5206, 3973, 6644, 5319, 5341, 8288, 5501, 5583, 5706, 5821, 5822, 5864, 5871, 2614, 6104, 8312, 1903, 6305, 6360, 6418, 6447, 6452, 6993, 6697, 6694, 1744, 6829, 4715, 6876, 7101, 7110, 1485, 7210, 6669, 7048, 7342, 2243, 7412, 7416, 7466, 6707, 7472, 7570, 4333, 4711, 7712, 7741, 7698, 7689, 7692, 7756, 3688, 7523, 8057, 8073, 8114, 8126, 4729, 8272, 8274, 8271, 8275, 3771, 7718, 8351, 8360, 8400, 8404, 8408, 8401, 8414, 8570, 8667, 8693, 8697, 8705, 8747, 8270, 1933, 156, 8812, 8814, 8813, 8815, 8816, 4899, 7923, 94, 1105, 6377, 1201, 5557, 7581, 5978, 5502, 1786, 2081, 4881, 8704, 2422, 725, 624, 5987, 3319, 2126, 1545, 1800, 5558, 2419, 792, 803, 1252, 1328, 5076, 8608, 2358, 8707, 4642, 7446, 8486, 3882, 8701, 6254, 3829, 3503, 724, 8690, 2069, 3841, 3834, 7097, 2267, 6953, 6261, 6558, 7447, 4154, 8694, 4488, 2035, 4081, 1042, 4403, 2814, 7854, 5942, 8268, 2764, 6894, 6449, 3974, 7520, 7341, 7515, 7524, 7525, 3423, 7791, 7926, 8276, 8281, 2264, 4085, 4707, 8345, 4366, 4371, 8056, 1255, 5825, 6256, 6253, 1746, 6205, 8374, 8027, 7649, 4334, 2818, 2093, 3094, 8811, 5217, 4569, 4568, 8222, 4251, 8086, 8741, 8742, 8743, 8749, 8763, 83, 157, 259, 640, 312, 310, 795, 719, 4988, 5203, 5338, 8822, 905, 902, 1232, 1261, 1115, 1415, 5559, 8699, 8691, 8700, 8696, 8698, 8703, 2564, 2658, 2288, 6597, 6594, 6590, 6106, 6922, 6422, 6430, 4088, 4107, 4175, 4258, 4252, 4308, 4464, 4490, 4489, 4658, 4646, 4654, 4772, 3903, 3976, 3977, 4021, 7845, 7829, 8482, 7940, 7953, 8137, 8233, 8296, 8297, 8301, 8291, 8375, 8377, 3501, 3147, 3148, 3556, 2936, 3361, 2996, 7668, 7343, 8152, 3528, 3529, 7209, 7214, 7716];

        return new NominativeCollection(
            $branch->nominatives()
                ->whereIn('teacher_id', $selection)
                ->orderBy('school_id')
                ->orderBy('serial')
                ->get()
        );
    }

    public function export()
    {
        return Excel::download(new TeacherExport, 'teachers.xlsx');
    }
}
