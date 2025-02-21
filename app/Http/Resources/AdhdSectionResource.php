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
            'status' => $this->status,
            'url' => $this->url,
            'page' => $this->page,
        ];
    }
}
