<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'work_duration' => $this->work_duration ?? '-',
            'show' => ($this->end_time)? false : true
        ];
    }
}
