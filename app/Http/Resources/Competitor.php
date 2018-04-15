<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Competitor extends JsonResource
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
            // Add 'position' only when the table is joined
            'position' => $this->whenPivotLoaded('race_competitors', function () {
                return $this->pivot->position;
            })
        ];
    }
}
