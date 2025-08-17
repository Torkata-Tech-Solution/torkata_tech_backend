<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SiteMetaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'logo' => $this->logo ? url(Storage::url($this->logo)) : null,
            'favicon' => $this->favicon ? url(Storage::url($this->favicon)) : null,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'tiktok' => $this->tiktok,
            'twitter' => $this->twitter,
            'youtube' => $this->youtube,
            'whatsapp' => $this->whatsapp,
            'telegram' => $this->telegram,
            'linkedin' => $this->linkedin,
            'about' => $this->about,
            'terms_conditions' => $this->terms_conditions,
        ];
    }
}
