<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutismsBookResource extends JsonResource
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
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'button_content' => $this->button_content,
            'button_link' => $this->button_link,
            'image' => $this->image,
            'status' => $this->status,
            'url' => $this->url,
        ];
    }
}
