<?php

namespace App\Models\Traits;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasAttachments
{
    use InteractsWithMedia;

    public function getMediaCollectionAttribute(): string
    {
        return 'document_file.' . $this->id;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50)->sharpen(10);
        $this->addMediaConversion('preview')->fit('crop', 120, 120)->sharpen(10);
    }

    public function getAttachmentsAttribute(): MediaCollection
    {
        $files = $this->getMedia($this->getMediaCollectionAttribute());
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });
        return $files;
    }
}
