<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'schools' => $this->schools_count,
            'teachers' => $this->teachers_count,
            'updates' => $this->updates_count,
            'verifies' => $this->verifies_count,
            'pinned' => false,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}