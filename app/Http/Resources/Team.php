<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Team extends JsonResource
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
            'name' => $this->name,
            'degree' => $this->degree,
            'twit' => $this->twit,
            'face' =>  $this->face,
            'instag' => $this->instag,
            'linkedn' => $this->linkedn,
            'image' => $this->image,
            'user_id' => $this->user_id,
            'sort' => $this->sort,
            'status' => $this->status,
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];

    }
}
