<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EndpointResource extends JsonResource
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
            'group' => $this->group,
            'method' => $this->method,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'project' => new ProjectResource($this->whenLoaded('project')),
        ];
    }
}
