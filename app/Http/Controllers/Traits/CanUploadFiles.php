<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Storage;

trait CanUploadFiles
{
    public function saveFile($filename, $file)
    {
        $file_path = self::STORAGE_PATH . '/' . $filename;

        $disk = Storage::disk(self::STORAGE_DISC);
        $disk->put($file_path, $file);

        return $file_path;
    }

}
