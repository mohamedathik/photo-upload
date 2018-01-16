<?php
namespace Mohamedathik\PhotoUpload;

use Aws\S3\Exception\S3Exception;
use Image;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class Upload
{
    public static function upload_original($file, $fileName, $location, $width = 1920, $height = null) {
        $s3 = Storage::disk(env('UPLOAD_TYPE', 'public'));

        $upload_location_rand = $location."/original/".time()."-".$fileName;

        $resized_image = Image::make($file)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $s3->put($upload_location_rand, $resized_image->stream()->__toString(), 'public');
        return $upload_location_rand;
    }

    public static function upload_thumbnail($file, $fileName, $location, $width = null, $height = 200) {
        $s3 = Storage::disk(env('UPLOAD_TYPE', 'public'));

        $upload_location = $location."/thumbnanil/".$fileName;
        $upload_location_rand = $location."/thumbnail/".time()."-".$fileName;

        $resized_image = Image::make($file)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        $s3->put($upload_location_rand, $resized_image->stream()->__toString(), 'public');
        return $upload_location_rand;
    }

    public static function upload_both($file, $fileName, $location) {
        $original = $this->upload_original($file, $fileName, $location);
        $thumbanil = $this->upload_thumbnail($file, $fileName, $location);

        return [
            'original' => $original,
            'thumbnail' => $thumbanil
        ];
    }

    public static function delete_image($location) {
        $s3 = Storage::disk(env('UPLOAD_TYPE', 'public'));

        if($s3->exists($location)) {
            $s3->delete($location);
            return true;
        }

        return false;
    }
}
