<?php

namespace App\Http\Controllers\Traits;

trait FileUpload {

    public function UploadPhoto($photos) {
        // dd($photos);
        foreach ($photos as $photo) {
            $path = $photo->store('images', ['disk' => 'public']);
            $photosUploaded[] = ["image" => $path];
        }
        return $photosUploaded;
    }

}
