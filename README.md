## Photo upload package
Note: This photo upload package is currently designed to be used only with laravel.

## Installation
Manually modify the `composer.json` file.

    "require": {
        "mohamedathik/photo-upload": "1.*"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:mohamedathik/photo-upload.git"
        }
    ],

and run `composer install`

## Usage
The following code can be moved to a controller, This is example is done in the `routes/web.php` file
1) Create a basic upload form in html
2) Create a route to handle the form post
    ```php
    Route::post('/photo', function (Request $request) {
        // The original file from rquest
        $file = $request->image;

        // Give it any file name you want (make sure to include the extension)
        $file_name = $file->getClientOriginalName();

        // Location that the file would be upload (Do not include the filename)
        $location = "/images";

        // Uploading of orignal image (this would return the location for original image including the filename)
        $url_original = Upload::upload_original($file, $file_name, $location);

        // Uploading of thumnail image (this would return the location for thumbnail image including the filename)
        $url_thumbnail = Upload::upload_thumbnail($file, $file_name, $location);

        echo $url_original."<br>".$url_thumbnail;
    });
    ```
    
If you want to delete and image use `delete()`. You need to pass the file location to this function. Here is an example route.
    
    ```php
    Route::post('/photo', function (Request $request) {
        // The original file from rquest
        $file = $request->image;

        // Give it any file name you want (make sure to include the extension)
        $file_name = $file->getClientOriginalName();

        // Location that the file would be upload (Do not include the filename)
        $location = "/images";

        // Uploading of orignal image (this would return the location for original image including the filename)
        $url_original = Upload::upload_original($file, $file_name, $location);

        // Uploading of thumnail image (this would return the location for thumbnail image including the filename)
        $url_thumbnail = Upload::upload_thumbnail($file, $file_name, $location);

        echo $url_original."<br>".$url_thumbnail;
    });
    ```
    
If there is any new update you need to run `composer update`.
