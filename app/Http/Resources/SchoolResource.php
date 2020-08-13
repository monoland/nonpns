<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
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
            'teachers' => $this->teachers_count,
            'updated' => $this->updates_count,
            'update_percent' => round($this->updates_count / $this->teachers_count * 100, 2) . '%',
            'verified' => $this->verifies_count,
            'verify_percent' => round($this->verifies_count / $this->teachers_count * 100, 2) . '%',
            'require' => $this->require,
            'available' => $this->available,
            'balance' => $this->balance,
            'details' => RequirementResource::collection($this->requirements),
            'pinned' => false,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
