<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Boards extends JsonResource
{
    public static $wrap = 'board';

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
            'image' => $this->image,
            'ownable_type' => $this->ownable_type === "App\Models\Team" ? "Team" : "User",
            'owner' => $this->ownable,
            'created_at' => CastDate($this->created_at),
        ];
    }
}
