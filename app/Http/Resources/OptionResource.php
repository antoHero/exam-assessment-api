<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Check if options array is empty
        if (empty($this->resource)) {
            return []; // Return empty array
        }

        return [
            'id' => $this->id,
            'content' => $this->content,
            'isAnswer' => $this->isAnswer,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'deletedAt' => $this->deleted_at
        ];
    }
}
