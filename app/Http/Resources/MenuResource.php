<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'link' => $this->link,
            'editing' => false,
            'key' => $this->id,
            'childs' => self::collection($this->childs),
            'custom_link' => (bool) $this->custom_link
        ];
    }
}
