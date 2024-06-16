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

    public static function unEncryptUserData(User $user): array
    {
        $userArr = $user->toArray();

        foreach ($userArr as $key => $value) {
            if ($key == 'first_name' or $key == 'last_name' or $key == 'middle_name'
            or $key == 'date_of_birth' or $key == 'phone') {
                if ($value != null) {
                    $userArr[$key] = Crypt::decrypt($value);
                }
            }
        }

        return $userArr;
    }
}
