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

        $s3->put($upload_location, $file, 'public');

        return $upload_location;
    }
}
