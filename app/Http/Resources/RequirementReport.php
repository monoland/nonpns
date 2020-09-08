<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequirementReport extends JsonResource
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
            'subject' => $this->subject->name,
            'require' => $this->require,
            'available' => $this->available,
            'honorer' => $this->honorer,
            'balance' => $this->balance,
        ];
    }
}
