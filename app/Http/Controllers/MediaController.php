<?php

namespace App\Http\Controllers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function __invoke(string $uuid)
    {
        $media = Media::findByUuid($uuid);
        $media->delete();

        return response()->json([
            'success' => 'Media has been deleted successfully!',
        ]);
    }
}
