<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasAttachments;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class Reply extends Model implements HasMedia
{
    use HasAttachments;

    protected $fillable = [
        'name',
    ];
}
