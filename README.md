
## Photo upload package
Note: This photo upload package is currently designed to be used only with laravel.
This is the version `v1.*` of the package.

This package uses `Intervention/Image` for image resizing and `league/flysystem-aws-s3-v3` for uploading to Amazon s3.
## Intallation
Manually modify the `composer.json` file and add the following.

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

I have included my full `composer.json` file below to check if you have added the above part correctly.

## Usage
1) This package supports uploading images to s3 or locally (which is inside the `storage\app\public` folder)
To specify the upload type add it to your .env file the default is public. If s3 is used make sure to include your api keys.
    ```
    UPLOAD_TYPE=(write here either 's3' or 'public')

    (include this if you choose s3)
    AWS_KEY=XXXXXXXXXXXXXXXXXXXX
    AWS_SECRET=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    AWS_REGION=XXXXXXXXXX
    AWS_BUCKET=XXXXXXXXXXX
    ```
2) Create a basic upload form in html, Make sure that the form has `enctype="multipart/form-data"` and to include a `csrf_field()`

    ```html
    <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="image">
        <button type="submit">Submit</button>    
    </form>
    ```
2) Create a route to handle the form post (The following code can be moved to a controller, This is example is done in the `routes/web.php` file)
    ```php
    Route::post('/photo', function (Request $request) {
        // The original file from rquest
        $file = $request->image;
    
        // Give it any file name you want (make sure to include the file extension, Using getClientOriginalName() would include the extension)
        $file_name = $file->getClientOriginalName();
    
        // Location that the file would be upload (Do not include the filename, Orginal and Thumbnail folder would be created automatically)
        $location = "/images";
    
        // Uploading of orignal image (this would return the location for original image including the filename)
        $url_original = Upload::upload_original($file, $file_name, $location);
    
        // Uploading of thumnail image (this would return the location for thumbnail image including the filename)
        $url_thumbnail = Upload::upload_thumbnail($file, $file_name, $location);
    
        echo $url_original."<br>".$url_thumbnail;
    });
    ```
For both the `upload_orginal()` and `upload_thumbnail()` it also accepts a width and a height.

The default for the `upload_orginal()` is `$width = 1920` and `$height = null`, if the variables is not passed manually.

The default for the `upload_thumbnail()` is `$width = null` and `$height = 200`, if the variables is not passed manually.

Note: By passing null to either width or height it will automatically select it based on the images orginal ratio. also this function does not enlarge any image if its smaller than the specified width or height.

    
If you want to delete a image then use `delete_image()`. You need to pass the file location to this function. Here is an example route.
```php
    Route::get('/photo/delete', function () {
        // Deleting the thumbnail image. For demonstration purpose I am passing the file name manually
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

## The full composer.json file
This is the full `composer.json` file

```json
{
    "name": "laravel/laravel",
    "description": "The Laravel Framework.",
    "keywords": ["framework", "laravel"],
    "license": "MIT",
    "type": "project",
    "require": {
        "php": ">=7.0.0",
        "fideloper/proxy": "~3.3",
        "laravel/framework": "5.5.*",
        "laravel/tinker": "~1.0",
        "mohamedathik/photo-upload": "1.*"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:mohamedathik/photo-upload.git"
        }
    ],
    "require-dev": {
        "filp/whoops": "~2.0",
        "fzaninotto/faker": "~1.4",
        "mockery/mockery": "~1.0",
        "phpunit/phpunit": "~6.0"
    },
    "autoload": {
        "classmap": [
            "database/seeds",
            "database/factories"
        ],
        "psr-4": {
            "App\\": "app/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "extra": {
        "laravel": {
            "dont-discover": [
            ]
        }
    },
    "scripts": {
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate"
        ],
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover"
        ]
    },
    "config": {
        "preferred-install": "dist",
        "sort-packages": true,
        "optimize-autoloader": true
    }
}

```
