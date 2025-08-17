<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'content' => $this->content,
            'thumbnail' => $this->getThumbnail(),
            'images' => $this->getImages(),
            'client_name' => $this->client_name,
            'project_url' => $this->project_url,
            'github_url' => $this->github_url,
            'technologies' => $this->technologies ?? [],
            'project_date' => $this->project_date?->format('Y-m-d'),
            'status' => $this->status,
            'order' => $this->order,
            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'photo' => $this->user->getPhoto()
            ],
            'meta' => [
                'title' => $this->meta_title,
                'description' => $this->meta_description,
                'keywords' => $this->meta_keywords
            ],
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s')
        ];
    }
}
