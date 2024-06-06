<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequset;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    // инициализация сервиса в контроллере
    public function __construct(protected UserService $userService){}


    /**
     *
     * Метод регистрации
     *
     * @OA\Schema( schema="registerUser",
     *           @OA\Property(property="success",type="boolean",example="true"),
     *           @OA\Property(property="user", ref="#/components/schemas/user"),
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
     * @param RegisterRequset $request
     * @return JsonResponse
     */
    public function register(RegisterRequset $request) {
        $data = $this->userService->register($request->get('login'),
            $request->get('email'),
            $request->get('password'));

        return $this->successResponse($data);
    }
}
