<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class DetailProductResource extends JsonResource
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
            'image' => $this->image,
            'stock' => $this->stock,
            'price' => $this->price,
            'description' => $this->description,
            'condition' => $this->condition,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'user' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'no_phone' => $this->user->no_phone,
                'address' => $this->user->address,
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
                    'created_at' => Carbon::parse($comment->created_at)->diffForHumans(),
                    'user' => [
                        'id' => $comment->user->id,
                        'username' => $comment->user->username,
                    ],
                ];
            })->toArray(),
        ];
    }
}
