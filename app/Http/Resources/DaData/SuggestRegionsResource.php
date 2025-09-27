<?php

namespace App\Http\Resources\DaData;

use Illuminate\Http\Resources\Json\JsonResource;

class SuggestRegionsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'kladrId' => $this->kladrId,
            'content_type' => $this->content_type,
            'name' => $this->name,
        ];
    }
}
