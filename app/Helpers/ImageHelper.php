<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageHelper
{
    public static function upload($image, string $path, ?int $width = null, ?int $height = null, ?string $oldImage = null): string
    {
        $extension = $image->getClientOriginalExtension();
        $filename = Str::random(10) . '_' . time() . '.' . $extension;
        $cleanPath = trim($path, '/');
        $dbPath = $cleanPath . '/' . $filename;
        $destinationPath = public_path($cleanPath);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $img = Image::read($image);
        if ($width || $height) {
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }
        $img->save($destinationPath . '/' . $filename);

        if ($oldImage && file_exists(public_path($oldImage))) {
            @unlink(public_path($oldImage));
        }
        return $dbPath;
    }
}
