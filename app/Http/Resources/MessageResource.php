<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'body' => $this->body,
            'deleted' => $this->trashed(),
            'create_at_dates' => [
                'create_at_human' => $this->created_at->diffForHumans(),
                'create_at' => $this->created_at,
            ],
            'sender' => new UserResource($this->sender),

        ];
    }
}
