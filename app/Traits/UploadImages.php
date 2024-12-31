<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadImages
{
    public function uploadImages($file, $directory, $oldImage = null)
    {
        if ($oldImage) {
            Storage::disk('public')->delete($oldImage);
        }
        $originalName = $file->getClientOriginalName();
        $cleanedName = str_replace(' ', '_', $originalName);
        $imageName = uniqid() . '_' . $cleanedName;
        $imagePath = $file->storeAs($directory, $imageName, 'public');
        return $imagePath;
    }
} 

