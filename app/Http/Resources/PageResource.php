<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'category' => $this->category,
            'font_size' => $this->font_size,
            'font_weight' =>$this->font_weight,
            'text_alignment' =>$this->text_alignment,
            'content_color' => $this->content_color,
            
        ];
    }
}
