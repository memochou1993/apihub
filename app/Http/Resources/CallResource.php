<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CallResource extends JsonResource
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
            'request' => $this->request,
            'response' => $this->response,
            'created_at' => $convertDate($this->created_at),
            'updated_at' => $convertDate($this->updated_at),
            'endpoint' => new EndpointResource($this->whenLoaded('endpoint')),
        ];
    }
}
