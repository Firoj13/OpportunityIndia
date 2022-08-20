<?php
/**
 * Created by PhpStorm.
 * User: Gulshan
 * Date: 3/12/21
 * Time: 5:08 PM
 */

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Helper
{
    const FILE_SERVER_S3 = 's3';
    const FILE_SERVER_VISIBILITY = 'public';

    /**
     * @param $path
     * @param $uploadPath
     * @param $fileType
     * @param bool $isDelete
     * @param string $deleteFileName
     * @param string $fileServer
     * @param string $visibility
     * @internal param string $deleteFilePath
     */
    public static function storageUpload($path, $uploadPath, $fileType,  $fileServer = self::FILE_SERVER_S3, $visibility = self::FILE_SERVER_VISIBILITY, $isDelete = false, $deleteFileName = '')
    {
        if (Storage::exists($path)) {
            $file = Storage::get($path);

            //Checking file type and doing required operations
            switch ($fileType){
                case Config('constants.IMAGE'):
                    $file = self::processImage($file);
                    break;
            }

            //Uploading to file server
            try {

                Storage::disk($fileServer)->put($uploadPath . basename($path), $file, $visibility);
            } Catch(\Exception $e) {
                echo $e->getMessage();
                die;
            }

            if($fileType == Config('constants.IMAGE') && in_array($uploadPath, [Config("constants.ARTICLE_UPLOAD_PATH"), Config("constants.ARTICLE_HINDI_UPLOAD_PATH")])  ) {

                foreach (Config('constants.IMAGE_UPLOAD_DIMENSIONS') as $key => $value) {

                    //Checking file type and doing required operations
                    $file = self::processImage($file, $value['WIDTH'], $value['HEIGHT']);

                    //Uploading to file server
                    try {
                        Storage::disk($fileServer)->put($uploadPath . $key ."/". basename($path), $file, $visibility);
                    } Catch(\Exception $e) {
                        echo $e->getMessage();
//                        die;
                    }
                }
            }

            //Deleting from local storage
            Storage::delete($path);
        }

        //Checking and deleting file if needed
        if($isDelete) {
            self::deleteFile($uploadPath, $deleteFileName, $fileServer);
        }
    }

    /**
     * @param $uploadPath
     * @param $deleteFileName
     * @param $fileServer
     * @internal param $deleteFilePath
     */
    public static function deleteFile($uploadPath, $deleteFileName, $fileServer)
    {
        try {
            //Deleting the file from file server
            Storage::disk($fileServer)->delete($uploadPath . $deleteFileName);
        } Catch(\Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * @param $file
     * @return \Intervention\Image\Image
     */
    public static function processImage($file, $width = 0, $height = 0)
    {
        if($height == 0) {
            $height = Config('constants.IMAGE_DIMENSIONS.MAIN_ARTICLE_NEWS_IMAGE.HEIGHT');
        }

        if($width == 0) {
            $width = Config('constants.IMAGE_DIMENSIONS.MAIN_ARTICLE_NEWS_IMAGE.WIDTH');
        }

        $file = Image::make($file);
        return $file->resize(
            $width,
            $height,
            function ($constraint) {
                $constraint->aspectRatio();
            })->encode();
    }
}
