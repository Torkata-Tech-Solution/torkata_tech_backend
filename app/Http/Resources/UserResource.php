<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'photo' => $this->photo ? url(Storage::url($this->photo)) : "https://ui-avatars.com/api/?background=15365F&color=C3A356&size=128&name=" . $this->name,
            'linkedIn' => $this->linkedIn,
            'github' => $this->github,
            'instagram' => $this->instagram,
            'last_login' => $this->last_login ? $this->last_login_at->toDateTimeString() : null,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
