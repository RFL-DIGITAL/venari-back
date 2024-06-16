<?php

namespace App;

use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class Helper
{
    public static function createNewImageModel($image): Image
    {
        $imageModel = new Image(
            [
                'image' => $image,
                'description' => 'Картинка в чате'
            ]
        );
        $imageModel->save();

        return $imageModel;
    }

}
