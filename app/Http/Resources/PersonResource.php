<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this['title'] ?? null,
            'first_name' => $this['first_name'] ?? null,
            'initial' => $this['initial'] ?? null,
            'last_name' => $this['last_name'] ?? null,
        ];
    }
}
