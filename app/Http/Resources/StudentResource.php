<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class StudentResource extends JsonResource
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
            'full_name' => $this->full_name,
            'student_phone' => $this->student_phone,
            'parent_phone' => $this->parent_phone,
            'student_email' => $this->student_email,
            'age' => $this->age,
            'address' => $this->address,
            'description' => $this->description,
            'current_class_id' => $this->current_class_id,
            'is_paid' => $this->is_paid,
            'start_date' => $this->start_date === null ? '' : Carbon::parse($this->start_date)->format('d/m/Y'),
            'end_date' => $this->end_date === null ? '' : Carbon::parse($this->end_date)->format('d/m/Y'),
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
