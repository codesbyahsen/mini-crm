<?php

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

/**
 * Upload image files in storage directory
 */
if (! function_exists('saveResizeImage')) {
    function saveResizeImage(object $file, string $directory, int|string $width, int|string|null $height = null, string $type = 'jpg')
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

/**
 * It returns the initial characters of name
 * from the users table accessing from auth
 */
if (! function_exists('getNameInitials')) {
    function getNameInitials(): string {
        $name = explode(' ', auth()->user()->name);
        return strtoupper($name[0][0] . $name[1][0]);
    }
}
