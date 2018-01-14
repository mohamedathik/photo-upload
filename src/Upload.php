<?php
namespace Mohamedathik\PhotoUpload;

use Aws\S3\Exception\S3Exception;
use Image;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class Upload
{
    public static function upload_original($file, $fileName, $location) {
        $s3 = Storage::disk(env('UPLOAD_TYPE', 'public'));

        $upload_location = $location."/original/".$fileName;
        $upload_location_rand = $location."/original/".time()."-".$fileName;

        $resized_image = Image::make($file)->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        if($s3->exists($upload_location)) {
            
            $s3->put($upload_location_rand, $resized_image->stream()->__toString(), 'public');
            return $upload_location_rand;

        } else {

            $s3->put($upload_location_rand, $resized_image->stream()->__toString(), 'public');
            return $upload_location;

        }

        return $upload_location;
    }

    public static function upload_thumbnail($file, $fileName, $location) {
        $s3 = Storage::disk(env('UPLOAD_TYPE', 'public'));

        $upload_location = $location."/thumbnanil/".$fileName;
        $upload_location_rand = $location."/thumbnail/".time()."-".$fileName;

        $resized_image = Image::make($file)->resize(null, 200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        if($s3->exists($upload_location)) {
            
            $s3->put($upload_location_rand, $resized_image->stream()->__toString(), 'public');
            return $upload_location_rand;

        } else {

            $s3->put($upload_location_rand, $resized_image->stream()->__toString(), 'public');
            return $upload_location;

        }

        return $upload_location;
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
