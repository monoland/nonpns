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
            'gender' => $this->gender,
            'born_place' => $this->born_place,
            'born_date' => $this->born_date,
            'status' => $this->status,
            'tmt' => $this->tmt,
            'merried' => $this->merried,
            'education' => [
                'value' => $this->education->id,
                'text' => $this->education->name,
            ],
            'register' => $this->register,
            'pinned' => false,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}