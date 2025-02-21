<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdhdSecondSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'second_title' => $this->second_title,
            'second_subtitle' => $this->second_subtitle,
            'second_description' => $this->second_description,
            'heading' => $this->heading,
            'second_sub_title' => $this->second_sub_title,
            'second_sub_description' => $this->second_sub_description,
            'second_image' => $this->second_image,
            'pointers' => json_decode($this->pointers),
            'status' => $this->status,
            'url' => $this->url,
            'page' => $this->page,
        ];
    }
}
