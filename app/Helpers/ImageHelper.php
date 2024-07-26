<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageHelper
{
    public static function generateName(UploadedFile $file) {
        $date = Carbon::now()->format('Ymd');
        $fileName =  $date . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $fileName;
    }

    public static function uploadImage(UploadedFile $file, $fileName, $folder = '')
    {
        // Lưu file vào thư mục storage/app/public/$folder
        return $file->storeAs('public/' . $folder, $fileName);
    }

    public static function removeImage($filename, $folder = '')
    {
        $path = 'public/' . $folder . '/' . $filename;

        if (Storage::exists($path)) {
            Storage::delete($path);
            return true;
        }

        return false;
    }
}
