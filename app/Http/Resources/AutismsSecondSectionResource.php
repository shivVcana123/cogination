<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutismsSecondSectionResource extends JsonResource
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
            'second_button_content' => $this->second_button_content,
            'second_button_link' => $this->second_button_link,
            'second_image' => $this->second_image,
            'pointers' => json_decode($this->pointers),
            'status' => $this->status,
            'url' => $this->url,
            'page' => $this->page,
        ];
    }
}
