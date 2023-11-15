<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'stock' => $this->stock,
            'price' => $this->price,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
            ],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'comments' => $this->comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'user_id' => $comment->user->id,
                    'content' => $comment->content,
                ];
            })->toArray(),
            // Add other related data as needed
        ];
    }
}
