<?php

namespace App\Http\Resources;

use App\Http\Resources\OrderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
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
            'code' => $this->code,
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
        ];
    }
}