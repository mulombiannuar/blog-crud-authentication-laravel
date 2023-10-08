<?php

namespace App\Actions\Admin;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class MediaUploading
{
    /**
     * Upload an incoming media file and returns its name
     *
     * @param  string<string, string>  $directory
     * @param  string<string, string>  $default_file
     * @param  mixed<string, string>  $file_name
     */
    public function upload($uploadedFile, string $directory, string $default_file, mixed $file_name): mixed
    {
        $path = public_path('assets/' . $directory);

        if ($uploadedFile && $uploadedFile->isValid()) {
            try {
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                if (!is_null($file_name)) {
                    $existingFileWithPath = $path . '/' . $file_name;
                    if (file_exists($existingFileWithPath) && $file_name !== $default_file) {
                        File::delete((public_path($existingFileWithPath)));
                    }
                }

                $extension = $uploadedFile->extension();

                $media_name = Str::random(25) . '_' . time() . '.' . $extension;

                $uploadedFile->move($path, $media_name);

                return $media_name;
            } catch (\Exception $e) {
                Log::error($e);
            }
        }

        return $file_name;
    }
}
