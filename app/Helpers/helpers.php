<?php

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

/**
 * Upload image files in storage directory
 */
if (! function_exists('saveResizeImage')) {
    function saveResizeImage($file, $directory, $width, $height = null, $type = 'jpg')
    {
        $fileName = uniqid() . '_' . time() . '.' . $type;
        $path = "$directory/$fileName";
        $img = Image::make($file)->orientate()->encode($type, 80)->resize($width, $height, function ($constraint) use ($height) {
            if (!$height) {
                $constraint->aspectRatio();
            }
            // $constraint->upsize();
        });
        $resource = $img->stream()->detach();
        Storage::disk('public')->put($path, $resource, 'public');
        return $path;
    }
}
