<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uid,
            'name' => $this->name,
            'option_values' => self::collection($this->values)->push([
                //empty value to show add new option field.
                'id' => strtoupper(\Illuminate\Support\Str::random(12)),
            ]),
        ];
    }
}
