<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class About extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'content' => $this->content,
            'image' =>  $this->image,
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];

    }
}
