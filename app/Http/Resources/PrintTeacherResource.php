<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrintTeacherResource extends JsonResource
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
            'name' => trim($front . $this->name . $back),
            'gender' => $this->gender,
            'born' => $this->born_place . ', ' . date('d F Y', strtotime($this->born_date)),
            'nik' => $this->nik,
            'status' => $this->status . ' Tidak Tetap',
            'education' => optional($this->education)->name ?: '-',
            'subject' => $this->subjects->pluck('name')->first() ?: '-',
            'school' => $this->school->name,
            'register' => $this->register ?: '-',
            'city' => $this->city->name
        ];
    }
}
