<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Classes extends JsonResource
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
            'class_name' => $this->class_name,
            'total_student' => $this->total_student,
            'course_id' => $this->course_id,
            'is_open' => $this->is_open,
            'description' => $this->description,
            'start_date' => $this->start_date === null ? '' : Carbon::parse($this->start_date)->format('d/m/Y'),
            'end_date' => $this->end_date === null ? '' : Carbon::parse($this->end_date)->format('d/m/Y'),
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
