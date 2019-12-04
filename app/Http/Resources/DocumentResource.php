<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'extn' => $this->extn,
            'type' => $this->type,
            'mime' => $this->mime,
            'path' => $this->path,
            'byte' => $this->byte,
            'furl' => $this->furl,
            'kind' => $this->kind,
            'kind_numb' => $this->kind_numb,
            'kind_date' => $this->kind_date,
            'kind_sign' => $this->kind_sign,
            'pinned' => false,
            'updated_at' => (string) $this->updated_at
        ];
    }
}
