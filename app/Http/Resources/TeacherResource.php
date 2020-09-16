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
        $front = $this->front_title ? $this->front_title . ' ' : '';
        $back = $this->back_title ? ', ' . $this->back_title . ' ' : '';

        return [
            'id' => $this->id,
            'nik' => $this->nik,
            'front_title' => $front,
            'name' => $this->name,
            'fullname' => trim($front . $this->name . $back),
            'back_title' => $back,
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
            'nominative' => $this->nominative,
            'merried' => [
                'value' => $this->merried,
                'text' => $this->merried,
            ],
            'education_text' => optional($this->education)->name,
            'education' => [
                'value' => optional($this->education)->id,
                'text' => optional($this->education)->name,
            ],
            'school_text' => optional($this->school)->name,
            'school' => [
                'value' => optional($this->school)->id,
                'text' => optional($this->school)->name,
            ],
            'branch' => [
                'value' => optional($this->branch)->id,
                'text' => optional($this->branch)->name,
            ],
            'verify' => $this->verify,
            'subject' => $this->subjects->pluck('name')->first() ?: '-',
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
