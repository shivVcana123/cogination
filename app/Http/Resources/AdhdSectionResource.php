<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdhdSectionResource extends JsonResource
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
            'first_title' => $this->first_title,
            'type' => $this->type,
            'first_subtitle' => $this->first_subtitle,
            'first_description' => $this->first_description,
            'first_button_content' => $this->first_button_content,
            'first_button_link' => $this->first_button_link,
            'first_image' => $this->first_image,
            'second_title' => $this->second_title,
            'second_subtitle' => $this->second_subtitle,
            'second_description' => $this->second_description,
            'second_sub_title' => $this->second_sub_title,
            'second_sub_description' => $this->second_sub_description,
            'second_image' => $this->second_image,
            'pointers' => json_decode($this->pointers),
            'status' => $this->status,
        ];
    }
}
