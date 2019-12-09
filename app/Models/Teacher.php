<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\TeacherResource;

class Teacher extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function education()
    {
        return $this->belongsTo(Education::class);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function subject()
    {
        return $this->belongsToMany(Subject::class)->wherePivot('mandatory', true);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class)
            ->withPivot('mandatory', 'harmony');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function school()
    {
        return $this->belongsToMany(School::class)->wherePivot('mandatory', true);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function schools()
    {
        return $this->belongsToMany(School::class)
            ->withPivot('mandatory');
    }

    /**
     * Scope for combo
     */
    public function scopeFetchCombo($query)
    {
        return $query->select(
            'name AS text', 'id AS value'
        )->get();
    }

    /**
     * Scope for filter
     */
    public function scopeFilterOn($query, $request)
    {
        $sortaz = $request->sortDesc === 'true' ? 'desc' : 'asc';
        $sortby = $request->has('sortBy') ? $request->sortBy : null;
        $search = $request->has('search') ? strtolower($request->search) : null;
        // $filton = $request->has('filterOn') ? $request->filterOn : null;
        // $filtby = $request->has('filterBy') ? $request->filterBy : null;

        $mixquery = $query;

        if ($search) {
            $mixquery = $mixquery->whereRaw("LOWER(name) LIKE '%{$search}%'");
        }

        // if ($filtby) {
        //     $mixquery = $mixquery->whereRaw("{$filton} = '{$filtby}'");
        // }

        if ($sortby) {
            $mixquery = $mixquery->orderBy($sortby, $sortaz);
        }

        return $mixquery;
    }

    /**
     * Store
     */
    public static function storeRecord($request)
    {
        DB::beginTransaction();

        try {
            $model = new static;
            // ...
            $model->save();

            DB::commit();

            return new TeacherResource($model);
        } catch (\Exception $e) {
            DB::rollBack();

            abort(500, $e->getMessage());
        }
    }

    /**
     * Update
     */
    public static function updateRecord($request, $model)
    {
        DB::beginTransaction();

        try {
            $model->nik = $request->nik;
            // $model->front_title = $request->front_title;
            // $model->name = $request->name;
            // $model->back_title = $request->back_title;
            $model->gender = $request->gender['value'];
            $model->born_place = $request->born_place;
            $model->born_date = $request->born_date;
            $model->status = $request->status;
            $model->tmt = $request->tmt;
            $model->merried = $request->merried['value'];
            $model->source = $request->source['value'];
            $model->education_id = $request->education['value'];
            $model->register = $request->register;
            $model->updated = true;
            $model->save();

            if ($request->documents && count($request->documents)) {
                foreach ($request->documents as $document) {
                    $xdocument = Document::find($document['id']);
                    
                    if ($xdocument) {
                        $xdocument->kind = $document['kind'];
                        $xdocument->kind_numb = $document['kind_numb'];
                        $xdocument->kind_date = $document['kind_date'];
                        $xdocument->kind_sign = $document['kind_sign'];
                        $xdocument->documentable_id = $model->id;
                        $xdocument->documentable_type = 'App\Models\Teacher';
                        $xdocument->save();
                    }
                }
            }

            if ($request->subjects && count($request->subjects)) {
                $subjects = [];

                foreach ($request->subjects as $index => $subject) {
                    if (is_array($subject)) {
                        $subjects[$subject['value']] = [
                            'mandatory' => $index === 0 ? true : false
                        ];
                    } else {
                        // addnew
                        $newSubject = Subject::firstOrCreate([
                            'name' => $subject,
                            'slug' => Str::slug($subject)
                        ]);
                        
                        $subjects[$newSubject->id] = [
                            'mandatory' => $index === 0 ? true : false
                        ];
                    }
                }

                $model->subjects()->sync($subjects);
            }

            DB::commit();

            return new TeacherResource($model);
        } catch (\Exception $e) {
            DB::rollBack();

            abort(500, $e->getMessage());
        }
    }

    /**
     * Destroy
     */
    public static function destroyRecord($model)
    {
        DB::beginTransaction();

        try {
            $model->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();

            abort(500, $e->getMessage());
        }
    }

    /**
     * Bulks
     */
    public static function bulkDelete($request, $model = null)
    {
        DB::beginTransaction();

        try {
            $bulks = array_column($request->all(), 'id');
            $rests = (new static)->whereIn('id', $bulks)->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();

            abort(500, $e->getMessage());
        }
    }
}
