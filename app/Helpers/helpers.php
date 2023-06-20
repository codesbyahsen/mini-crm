<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

/**
 * Upload image files in storage directory
 */
if (!function_exists('saveResizeImage')) {
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
if (!function_exists('getNameInitials')) {
    function getNameInitials(): ?string
    {
        switch (Auth::check()) {
            case Auth::guard('employee')->check():
                return strtoupper(Auth::guard('employee')->user()->first_name[0] . Auth::guard('employee')->user()->last_name[0]);
            case Auth::guard('web')->check():
                return strtoupper(Auth::guard('web')->user()->first_name[0] . Auth::guard('web')->user()->last_name[0]);
            default:
                return null;
        }
    }
}
