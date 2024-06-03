<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequset;
use App\Services\UserService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
class UserController extends Controller
{

    // иництализация сервиса в контроллере
    public function __construct(protected UserService $userService){}


    /**
     *
     * Метод регистрации
     *
     *
     *
     * @OA\Schema( schema="registerUser",
     *           @OA\Property(property="success",type="boolean",example="true"),
     *           @OA\Property(property="user",type="string",example="user"),
     *           @OA\Property(property="access_token",type="string"),
     *      )
     *
     * @OA\Get(
     *      path="/api/register",
     *      tags={"UserController"},
     *      @OA\Response(
     *      response="200",
     *      description="Ответ при успешном выполнении запроса",
     *      @OA\JsonContent(ref="#/components/schemas/registerUser")
     *    )
     *  )
     *
     * @param RegisterRequset $requset
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequset $requset) {
        $data = $this->userService->register($requset->get('login'),
            $requset->get('email'),
            $requset->get('password'));

        return $this->successResponse($data);
    }
}
