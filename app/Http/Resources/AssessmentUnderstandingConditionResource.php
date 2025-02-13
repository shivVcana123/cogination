<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentUnderstandingConditionResource extends JsonResource
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
            'description' => $this->description,
            'button_content' => $this->button_content,
            'button_link' => $this->button_link,
            'pointers' => $this->pointers,
            'status' => $this->status,
            'url' => $this->url,
        ];
    }
}
