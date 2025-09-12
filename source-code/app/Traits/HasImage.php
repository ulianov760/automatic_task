<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;


trait HasImage
{
    public function uploadImage($value, $destinationPath, $model, $nameAttribute, $disk = 'public')
    {
        if (Str::startsWith($value, 'data:image')) {
            $imageData = substr($value, strpos($value, ',') + 1);
            $imageData = base64_decode($imageData);

            $this->deletePreviousImage($nameAttribute, $model, $disk);

            $image = Image::make($value);
            $format = str_replace('image/', '', $image->mime());
            $fileName = md5($value . time()) . '.' . $format;
            $filePath = $destinationPath . '/' . $fileName;
            Storage::disk($disk)->put($filePath, $imageData, 'public');

            $publicDestinationPath = Str::replaceFirst('public/', '', $destinationPath);
            return $publicDestinationPath . '/' . $fileName;
        }
    }

    private function deletePreviousImage($attribute_name, $model, $disk)
    {
        if (isset($model->{$attribute_name}) && !empty($model->{$attribute_name})) {
            Storage::disk($disk)->delete($model->{$attribute_name});
        }
    }


}
