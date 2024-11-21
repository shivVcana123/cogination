<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteStyleResource extends JsonResource
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
            'title_style' => $this->title_style,
            'subtitle_style' => $this->subtitle_style,
            'description_style' => $this->description_style,
            'button_content_style' => $this->button_content_style,
            'footer_color' => $this->footer_color,
            'footer_image' => $this->footer_image,
            'header_color' => $this->header_color,
            'header_image' => $this->header_image,
        ];
    }
}
