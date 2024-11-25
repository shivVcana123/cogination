<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteStyleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title_style' => $this->extractCSSWithTags($this->title_style),
            'subtitle_style' => $this->extractCSSWithTags($this->subtitle_style),
            'description_style' => $this->extractCSSWithTags($this->description_style),
            'button_content_style' => $this->extractCSSWithTags($this->button_content_style),
            'footer_color' => $this->footer_color,
            'header_color' => $this->header_color,
        ];
    }

    protected function extractCSSWithTags($html)
    {
        // Decode HTML entities
        $html = html_entity_decode($html);

        // Extract the CSS style from the `style` attribute
        preg_match('/style="([^"]*)"/i', $html, $styleMatches);
        $style = $styleMatches[1] ?? null;

        // Extract all tags
        preg_match_all('/<(\w+)>/i', $html, $tagMatches);
        $tags = array_unique($tagMatches[1]);

        // Format tags and their content into an array
        $tagContentArray = [];
        foreach ($tags as $tag) {
            $tagContentArray[] = [
                'tag' => $tag,
                'content' => strip_tags($html, "<$tag>")
            ];
        }

        return [
            'style' => $style,
            'tags' => $tagContentArray,
        ];
    }
}
