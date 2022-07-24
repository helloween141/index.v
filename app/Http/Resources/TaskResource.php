<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'user_id' => new UserResource($this->user),
            'executor_id' => new UserResource($this->user),
            'client_id' => new ClientResource($this->client),
            'short_description' => $this->short_description,
            'full_description' => $this->full_description,
            'type' => $this->type,
            'status' => $this->status,
            'priority' => $this->priority,
            'tech_comment' => $this->tech_comment,
            'client_comment' => $this->client_comment,
            'client_time' => $this->client_time,
            'created_at' => $this->created_at,
            'deadline_at' => $this->deadline_at,
            'finished_at' => $this->finished_at,
        ];
    }
}
