<?php

 namespace App\Services;

 use App\Models\User;
 use Illuminate\Support\Facades\Auth;
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
    public function register(string $login, string $email, string $password): array {
        $user = new User;
        $user->name = $login;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();
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

            $user = Auth::user();
            $data['token'] = $user->createToken('User Token')->accessToken;
            $data['data'] = $user;

            return [true, $data];
        }  else {
            return [false, 'error' => 'Unauthorization or user is not found.'];
        }
    }

 }
