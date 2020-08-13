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
            'sma' => $this->sma_count,
            'smk' => $this->smk_count,
            'skh' => $this->skh_count,
            'teachers' => $this->teachers_count,
            'require' => $this->schools->sum('require'),
            'available' => $this->schools->sum('available'),
            'balance' => $this->schools->sum('balance'),
            'updated' => $this->updates_count,
            'update_percent' => round($this->updates_count / $this->teachers_count * 100, 2) . '%',
            'verified' => $this->verifies_count,
            'verify_percent' => round($this->verifies_count / $this->teachers_count * 100, 2) . '%',
            'pinned' => false,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
