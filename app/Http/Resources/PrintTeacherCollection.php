<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PrintTeacherCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return PrintTeacherResource::collection($this->collection);
    }

    public function with($request)
    {
        return [
            'additional' => [
                'info' => $request->branch->name,
            ],
        ];
    }
}
