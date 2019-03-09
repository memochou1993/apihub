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
        $convertDate = function ($date) use ($request) {
            return $request->diffForHumans ? $date->diffForHumans() : $date->toDateTimeString();
        };

        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $convertDate($this->created_at),
            'updated_at' => $convertDate($this->updated_at),
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
        ];
    }
}
