<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Blog */
class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => strval($this->id),
            'type' => 'blog_post',
            'attributes' => [
                'title' => $this->title,
                'body' => $this->body,
                'author' => $this->author,

                'image' => [
                    'file_name' => $this->image->file_name, // @phpstan-ignore-line
                    'mime_type' => $this->image->mime_type,// @phpstan-ignore-line
                    'size' => $this->image->size,// @phpstan-ignore-line
                    'original_url' => $this->image->original_url,// @phpstan-ignore-line
                ]
            ],
            'relationships' => [

            ]
        ];
    }
}