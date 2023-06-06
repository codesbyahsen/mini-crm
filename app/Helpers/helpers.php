<?php

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

/**
 * Upload files and images in storage directory
 */
if (!function_exists('file_upload')) {
    function image_upload(object $image, int|string $width, int|string $height, string|null $path = null, string|null $prefix = null): string
    {
        $basePath = 'app/public/uploads/';

        $imageName = null;
        if (File::isFile($image) && !is_null($image)) {
            $imageName = $prefix ? ($prefix . '_' . uniqid() . '_' . time() . '.' . $image->extension()) : (uniqid() . '_' . time() . '.' . $image->extension());
            $path = storage_path($basePath . $path . '/' . $imageName);

            $img = Image::make($image->getRealPath());
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path);
        }

        return $imageName;
    }
}
