<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeBringingHealthcareResource extends JsonResource
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
            'button_content1' => $this->button_content1,
            'button_link1' => $this->button_link1,
            'button_content2' => $this->button_content1,
            'button_link2' => $this->button_link1,
            'image' => $this->image,
        ];
    }
}
