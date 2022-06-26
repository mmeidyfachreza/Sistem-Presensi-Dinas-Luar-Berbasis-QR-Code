<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PresenceResource extends JsonResource
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
            'startTime' => $this->start_time ?? 'belum dicatat',
            'endTime' => $this->end_time ?? 'belum dicatat',
            'work_duration' => Carbon::parse($this->work_duration)->diffForHumans(null,true) ?? '-',
            'show' => ($this->end_time)? false : true
        ];
    }
}
