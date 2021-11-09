<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Reply extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name'
    ];

    public function getMediaCollectionAttribute(): string
    {
        return 'document_file.' . $this->id;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(80)
            ->height(80)
            ->sharpen(10)
            ->extractVideoFrameAtSecond(10)
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->width(320)
            ->height(320)
            ->sharpen(10)
            ->extractVideoFrameAtSecond(10);
    }

    public function getPreviewsAttribute()
    {
        #dd($this->getMedia('document_file')->all());
        return $this->getMedia($this->media_collection);
    }


    public function getAttachmentsAttribute()
    {
        return $this->getMedia($this->media_collection)->all();
    }
}
