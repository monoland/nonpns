<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Resources\DocumentResource;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
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
    public function documentable()
    {
        return $this->morphTo();
    }

    /**
     * Scope for combo.
     */
    public function scopeFetchCombo($query)
    {
        return $query->select(
            'name AS text',
            'id AS value'
        )->get();
    }

    /**
     * Scope for filter.
     */
    public function scopeFilterOn($query, $request)
    {
        $sortaz = $request->sortDesc === 'true' ? 'desc' : 'asc';
        $sortby = $request->has('sortBy') ? $request->sortBy : null;
        $search = $request->has('search') ? strtolower($request->search) : null;

        $mixquery = $query;

        if ($search) {
            $mixquery = $mixquery->whereRaw("LOWER(name) LIKE '%{$search}%'");
        }

        if ($sortby) {
            $mixquery = $mixquery->orderBy($sortby, $sortaz);
        }

        return $mixquery;
    }

    /**
     * Undocumented function.
     *
     * @param [type] $request
     */
    public static function chunkRecord($request)
    {
        $chunk_inpt = 'fileUpload';
        $chunk_fldr = 'chunks';
        $chunk_maxi = 48;
        $chunk_mxsz = 250000;
        $chunk_uuid = $request->uuid;
        $chunk_indx = (int) $request->partIndex;

        try {
            if ($chunk_indx === 0) {
                $chunk_strg = $chunk_uuid;
                $chunk_hash = sha1($chunk_strg);

                if ($current = (new static())->where('hash', $chunk_hash)->first()) {
                    return response()->json([
                        'success' => false,
                        'error' => 'File is already exists.',
                        'preventRetry' => true,
                        'record' => new DocumentResource($current)
                    ], 200);
                }

                if ($request->totalParts > $chunk_maxi || $request->chunkSize > $chunk_mxsz) {
                    return response()->json([
                        'success' => false,
                        'error' => 'File or chunk size is too large.',
                        'preventRetry' => true,
                    ], 500);
                }
            }

            $file = $request->file($chunk_inpt);

            $file->storeAs($chunk_uuid, $chunk_indx, $chunk_fldr);

            return response()->json([
                'success' => true,
                'uuid' => $chunk_uuid
            ], 200);
        } catch (\Exception $e) {
            (new static())->cleanChunks($chunk_uuid);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'preventRetry' => true,
            ], 500);
        }
    }

    /**
     * Store.
     */
    public static function storeRecord($request)
    {
        DB::beginTransaction();

        $model = new static();

        $chunk_uuid = $request->uuid;
        $chunk_ttal = $request->totalParts;
        $chunk_file = explode('.', $request->fileName);
        $chunk_extn = array_pop($chunk_file);

        $chunk_path = storage_path('chunks' . DIRECTORY_SEPARATOR . $chunk_uuid);
        $store_path = 'uploads' . DIRECTORY_SEPARATOR . $chunk_uuid . '.' . $chunk_extn;
        $media_path = storage_path($store_path);

        try {
            $media_trgt = fopen($media_path, 'wb');

            for ($i = 0; $i < $chunk_ttal; ++$i) {
                $chunk = fopen($chunk_path . DIRECTORY_SEPARATOR . $i, 'rb');
                stream_copy_to_stream($chunk, $media_trgt);
                fclose($chunk);
            }

            fclose($media_trgt);

            $model->cleanChunks($chunk_uuid);

            $model->name = $request->fileName;
            $model->byte = File::size(storage_path($store_path));
            $model->extn = File::extension(storage_path($store_path));
            $model->type = File::type(storage_path($store_path));
            $model->mime = File::mimeType(storage_path($store_path));
            $model->path = $chunk_uuid . '.' . $model->extn;
            $model->hash = sha1($chunk_uuid);

            if (in_array(strtolower($model->extn), ['jpg', 'jpeg', 'png'])) {
                $model->furl = '/mediafiles/original/' . $chunk_uuid . '.' . $model->extn;
            }

            $request->user()->documents()->save($model);

            DB::commit();

            return response()->json([
                'success' => true,
                'uuid' => $chunk_uuid,
                'record' => new DocumentResource($model),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            $model->cleanChunks($chunk_uuid);

            // abort(500, $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'preventRetry' => true,
            ], 500);
        }
    }

    /**
     * Update.
     */
    public static function updateRecord($request, $model)
    {
        DB::beginTransaction();

        try {
            $model->name = $request->name;
            $model->type = $request->type;
            $model->save();

            DB::commit();

            return new DocumentResource($model);
        } catch (\Exception $e) {
            DB::rollBack();

            abort(500, $e->getMessage());
        }
    }

    /**
     * Destroy.
     */
    public static function destroyRecord($model)
    {
        DB::beginTransaction();

        try {
            $model->delete();

            File::delete(storage_path(
                'uploads' . DIRECTORY_SEPARATOR . $model->path
            ));

            DB::commit();

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            abort(500, $e->getMessage());
        }
    }

    /**
     * Bulks.
     */
    public static function bulkDelete($request, $model = null)
    {
        DB::beginTransaction();

        try {
            $bulks = array_column($request->all(), 'id');
            $rests = (new static())->whereIn('id', $bulks)->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();

            abort(500, $e->getMessage());
        }
    }

    public function cleanChunks($uuid)
    {
        try {
            $dir = storage_path('chunks' . DIRECTORY_SEPARATOR . $uuid);

            $its = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
            $fls = new \RecursiveIteratorIterator($its, \RecursiveIteratorIterator::CHILD_FIRST);

            foreach ($fls as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }

            rmdir($dir);
        } catch (\Exception $e) {
            return false;
        }
    }
}
