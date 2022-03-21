<?php

use App\Models\SystemLog;
use Intervention\Image\Facades\Image;

/**
 * Creates thumbnail for given image.
 */
function makeThumbnail(string $path, string $filename, string $size)
{
    $segments  = explode('x', $size);
    $thumbPath = sprintf('%s/thumbnails/%s/%s/%s/%s', config('codictive.static_dir'), $segments[0], $segments[1], $path, $filename);

    // create directories if necessary.
    $dirname = sprintf('%s/thumbnails/%s/%s/%s', config('codictive.static_dir'), $segments[0], $segments[1], $path);
    if (! file_exists($dirname)) {
        mkdir($dirname, 0755, true);
    }

    $filePath = sprintf('%s/%s/%s', config('codictive.static_dir'), $path, $filename);
    if (! file_exists($filePath)) {
        return;
    }

    try {
        $image  = Image::make($filePath);
        $width  = (int) $segments[0];
        $height = '_' == $segments[1] ? null : (int) $segments[1];
        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($thumbPath, 80);
    } catch (Exception $e) {
        SystemLog::error('Helpers.makeThumbnail', "can't create image thumbnail: %s (%d)", $e->getMessage(), $e->getCode());
    }
}

/**
 * Returns thumbnail url for given image.
 */
function getThumbnail(string $path, string $filename, string $size): string
{
    $segments  = explode('x', $size);
    $thumbPath = sprintf('%s/thumbnails/%s/%s/%s/%s', config('codictive.static_dir'), $segments[0], $segments[1], $path, $filename);
    if (file_exists($thumbPath)) {
        return sprintf('/static/thumbnails/%s/%s/%s/%s', $segments[0], $segments[1], $path, $filename);
    }

    makeThumbnail($path, $filename, $size);

    return sprintf('/static/thumbnails/%s/%s/%s/%s', $segments[0], $segments[1], $path, $filename);
}
