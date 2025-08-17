<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Portfolio extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logUnguarded()
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn (string $eventName) => "This model has been {$eventName}");
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'images' => 'array',
        'technologies' => 'array',
        'project_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getThumbnail()
    {
        return $this->thumbnail ? Storage::url($this->thumbnail) : 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg';
    }

    public function getImages()
    {
        if (!$this->images) {
            return [];
        }

        return array_map(function ($image) {
            return Storage::url($image);
        }, $this->images);
    }
}
