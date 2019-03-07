<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'private' => (bool) $this->private,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'environments' => EnvironmentResource::collection($this->whenLoaded('environments')),
        ];
    }
}
