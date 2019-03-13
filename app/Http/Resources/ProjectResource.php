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
        $convertDate = function ($date) use ($request) {
            return $request->diffForHumans ? $date->diffForHumans() : $date->toDateTimeString();
        };

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'private' => (bool) $this->private,
            'created_at' => $convertDate($this->created_at),
            'updated_at' => $convertDate($this->updated_at),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'environments' => EnvironmentResource::collection($this->whenLoaded('environments')),
            'endpoints' => EndpointResource::collection($this->whenLoaded('endpoints')),
            'calls' => CallResource::collection($this->whenLoaded('calls')),
        ];
    }
}
