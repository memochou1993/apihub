<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $created_at = $request->diffForHumans
            ? $this->created_at->diffForHumans()
            : $this->created_at->toDateTimeString();

        $updated_at = $request->diffForHumans
            ? $this->updated_at->diffForHumans()
            : $this->updated_at->toDateTimeString();

        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
        ];
    }
}
