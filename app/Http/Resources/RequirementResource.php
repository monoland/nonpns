<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequirementResource extends JsonResource
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
            'status' => $this->status,
            'subject' => [
                'value' => $this->subject->id,
                'text' => $this->subject->name,
            ],
            'require' => $this->require,
            'available' => $this->available,
            'balance' => $this->balance,

            'pinned' => false,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
