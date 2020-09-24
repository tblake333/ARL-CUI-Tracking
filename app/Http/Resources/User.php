<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Item as ItemResource;

class User extends JsonResource
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
            'badge_number' => $this->badge_number,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'items' => ItemResource::collection($this->items)
        ];
    }
}
