<?php
namespace Mohamedathik\PhotoUpload;

use Aws\S3\Exception\S3Exception;
use Image;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class Upload
{
    public static function upload($file, $fileName, $location) {
        $s3 = Storage::disk(env('UPLOAD_TYPE', 'public'));
        $upload_location = $location . "/" . $fileName;

        $original = Image::make($file)->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $s3->put($upload_location, $original->stream()->__toString(), 'public');

        return $upload_location;
    }
}
