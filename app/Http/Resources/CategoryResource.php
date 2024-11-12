<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'handle' => $this->handle,
            'picture_url' => $this->picture_url,
            'childs' => self::collection($this->childs),
            'parent_id' => $this->parent_id,
            'parent_name' => $this->parent_name,
            'parent_handle' => $this->parent->handle ?? null,
        ];
    }
}
