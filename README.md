
## Photo upload package
Note: This photo upload package is currently designed to be used only with laravel.
This is the version `v1.*` of the package
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
1) Create a basic upload form in html, Make sure that the form has `enctype="multipart/form-data"` and to include a `csrf_field()`
    ```html
    <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="image" id="">
        <button type="submit">Submit</button>    
    </form>
    ```
2) Create a route to handle the form post (This part can be done inside a controller)
    ```php
    Route::post('/photo', function (Request $request) {
        // The original file from rquest
        $file = $request->image;
    
        // Give it any file name you want (make sure to include the file extension)
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
    
If you want to delete a image then use `delete_image()`. You need to pass the file location to this function. Here is an example route.
```php
    Route::get('/photo/delete', function () {
        // Deleting the thumbnail imaege for demonstration purpose I am passing the file name manually
        $delete_thumbnail_image = Upload::delete_image('/images/original/1515931209-Image.jpg');
        // The variable above will always return a true or false value
        // true  is returned if image is deleted 
        // and false is returned if image could not be found
        if ($delete_thumbnail_image) {
            return 'Successfully deleted';
        } else {
            return 'Image could not be found';
        }
    });
```
If there is any new update to this package you need to run `composer update`.
