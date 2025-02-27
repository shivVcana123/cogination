<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeWhyChooseUsResource extends JsonResource
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
            'pointers' => $this->pointers,
            'image' => $this->image,
            'status' => $this->status,
            'url' => $this->url,
            'page' => $this->page,
        ];
    }
}
