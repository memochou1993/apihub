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
        $convertDate = function ($date) use ($request) {
            return $request->diffForHumans ? $date->diffForHumans() : $date->toDateTimeString();
        };

        return [
            'id' => $this->id,
            'name' => $this->name,
            'method' => $this->method,
            'uri' => $this->uri,
            'description' => $this->description,
            'created_at' => $convertDate($this->created_at),
            'updated_at' => $convertDate($this->updated_at),
            'project' => new ProjectResource($this->whenLoaded('project')),
            'calls' => CallResource::collection($this->whenLoaded('calls')),
        ];
    }
}
