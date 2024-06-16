<?php

namespace App\Services;

use App\Helper;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;


/**
 * Сервис взаимодействия с пользователем
 */
class UserService
{


    /**
     * Метод регистрации пользователя
     *
     * возвращает пользователя и accessToken
     *
     * @param string $login
     * @param string $email
     * @param string $password
     * @return array
     */
    public function register(string        $first_name,
                             ?string       $middle_name,
                             string        $last_name,
                             ?string       $birth_date,
                             string        $email,
                             string        $password,
                             ?string       $phone,
                             string        $user_name,
                             bool          $sex,
                             ?UploadedFile $image
    ): array
    {
        $user = new User;
        $user->first_name = $first_name;
        $user->middle_name = $middle_name;
        $user->last_name = $last_name;
        $user->date_of_birth = $birth_date;
        $user->email = $email;
        $user->phone = $phone;
        $user->password = Hash::make($password);
        $user->user_name = $user_name;
        $user->sex = $sex;
        $user->save();

        if ($image != null) {
            $imageModel = Helper::createNewImageModel($image);
            $user->image_id = $imageModel->id;
            $user->save();
        }

        $token = $user->createToken('Access Token')->accessToken;
        $data = [
            'user' => $user,
            'access_token' => $token,
        ];

        return $data;
    }

    /**
     *
     * Метод логина\авторизации
     *
     * возвращает массив, первый элемент отвечает за успех операции
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public function login(string $email, string $password): array
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {

//            dd('123');
            $user = Auth::user();
            $data['token'] = $user->createToken('User Token')->accessToken;
            $data['data'] = $user;

            return [true, $data];
        } else {
            return [false, 'error' => 'Unauthorised or user is not found.'];
        }
    }

}
