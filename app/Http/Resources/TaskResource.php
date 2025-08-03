<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'assigned_to' => [
                'id' => $this->assignedUser->id,
                'name' => $this->assignedUser->name,
                'email' => $this->assignedUser->email,
            ],
            'created_by' => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
            ],
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_completed' => $this->is_completed,
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
