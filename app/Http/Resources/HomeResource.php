<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
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
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description_1' => $this->description_1,
            'button_content' => $this->button_content,
            'button_link' => $this->button_link,
            'image' => $this->image,
            'background_image' => $this->background_image,
            'background_color' => $this->background_color,
        ];
    }
}
