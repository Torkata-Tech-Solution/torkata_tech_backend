<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class NewsResource extends JsonResource
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
            'thumbnail' => $this->thumbnail ? url(Storage::url($this->thumbnail)) : null,
            'content' => $this->content,
            'comments_count' => $this->comments->count(),
            'viewers_count' => $this->viewers->count(),
            'meta' => [
                'title' => $this->meta_title,
                'description' => $this->meta_description,
                'keywords' => $this->meta_keywords,
            ],
            'category' => [
                'id' => $this->category->id,
                'slug' => $this->category->slug,
                'name' => $this->category->name,
            ],
            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'position' => $this->user->position,
                'bio' => $this->user->bio,
                'photo' => $this->user->photo ? url(Storage::url($this->user->photo)) : "https://ui-avatars.com/api/?background=15365F&color=C3A356&size=128&name=" . $this->name,
                'linkedIn' => $this->user->linkedIn,
                'github' => $this->user->github,
                'instagram' => $this->user->instagram,
            ],
            'comments' => $this->comments->whereNull('parent_id')->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'name' => $comment->name,
                    'email' => $comment->email,
                    'comment' => $comment->comment,
                    'status' => $comment->status,
                    'is_guest' => $comment->user_id ? false : true,
                    'created_at' => $comment->created_at->toDateTimeString(),
                    'updated_at' => $comment->updated_at->toDateTimeString(),
                    'reply' => $comment->children->map(function ($child) {
                        return [
                            'id' => $child->id,
                            'name' => $child->name,
                            'email' => $child->email,
                            'comment' => $child->comment,
                            'status' => $child->status,
                            'is_guest' => $child->user_id ? false : true,
                            'created_at' => $child->created_at->toDateTimeString(),
                            'updated_at' => $child->updated_at->toDateTimeString(),
                        ];
                    }),
                ];
            }),
            'share' => [
                'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=https://torkatatech.com/blog/' . $this->slug,
                'twitter' => 'https://twitter.com/intent/tweet?url=https://torkatatech.com/blog/' . $this->slug . '&text=' . urlencode($this->title),
                'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=https://torkatatech.com/blog/' . $this->slug . '&title=' . urlencode($this->title) . '&summary=' . urlencode($this->meta_description),
                'whatsapp' => 'https://api.whatsapp.com/send?text=https://torkatatech.com/blog/' . $this->slug . ' - Blog Terbaru dari Torkata Tech : ' . urlencode($this->title),
            ],
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
