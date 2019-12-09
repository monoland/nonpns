<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'nik' => $this->nik,
            'front_title' => $this->front_title,
            'name' => $this->name,
            'back_title' => $this->back_title,
            'gender' => [
                'value' => $this->gender,
                'text' => $this->gender === 'L' ? 'Laki-laki' : 'Perempuan'
            ],
            'born_place' => $this->born_place,
            'born_date' => $this->born_date,
            'status' => $this->status,
            'source' => [
                'value' => $this->source,
                'text' => $this->source
            ],
            'tmt' => $this->tmt,
            'merried' => [
                'value' => $this->merried,
                'text' => $this->merried,
            ],
            'education' => [
                'value' => optional($this->education)->id,
                'text' => optional($this->education)->name,
            ],
            'subjects' => SubjectList::collection($this->subjects),
            'documents' => DocumentResource::collection($this->documents),
            'register' => $this->register,
            'updated' => $this->updated,
            'verified' => $this->verified,
            'pinned' => false,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}