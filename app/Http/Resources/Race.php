<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Race extends JsonResource
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
            'close_time' => $this->close_time->format('Y-m-d H:i:s'),
            'meeting' => new Meeting($this->meeting),
            'competitors' => Competitor::collection($this->whenLoaded('competitors'))
        ];
    }
}
