<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    // инициализация сервиса в контроллере
    public function __construct(protected UserService $userService)
    {
    }


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
     * @OA\Post(
     *      path="/api/register",
     *      tags={"UserController"},
     *      @OA\RequestBody(ref="#/components/requestBodies/RegisterRequest"),
     *      @OA\Response(
     *      response="200",
     *      description="Ответ при успешном выполнении запроса",
     *      @OA\JsonContent(ref="#/components/schemas/registerUser")
     *    )
     *  )
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = $this->userService->register($request->get('login'),
            $request->get('email'),
            $request->get('password'));

        return $this->successResponse($data);
    }


    /**
     * метод авторизации пользователя. возвращает токен
     *
     *
     * @OA\Schema( schema="loginUser",
     *            @OA\Property(property="success",type="boolean",example="true"),
     *            @OA\Property(property="user", ref="#/components/schemas/user"),
     *            @OA\Property(property="token",type="string"),
     *       )
     *
     *
     * @OA\Post(
     *   path="/api/login",
     *   tags={"UserController"},
     *   @OA\RequestBody(ref="#/components/requestBodies/LoginRequest"),
     *   @OA\Response(
     *       response="200",
     *      description="Ответ при успешном выполнении запроса",
     *       @OA\JsonContent(ref="#/components/schemas/loginUser")
     *   )
     * )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        list($success, $data) = $this->userService->login(
            $request->get('email'),
            $request->get('password')
        );
        if ($success) {
            return $this->successResponse($data);
        }
        return $this->failureResponse($data);
    }

    /**
     * Метод получения информации о пользователи по его id
     *
     * @OA\Schema( schema="show",
     *                @OA\Property(property="success",type="boolean",example="true"),
     *                @OA\Property(property="response", ref="#/components/schemas/userWithResume"),
     *     )
     *
     * @OA\Get(
     *          path="/api/users/{id}",
     *          tags={"UserController"},
     *      @OA\Parameter(
     *           name="id",
     *      in="path",
     *           description="id пользователя",
     *           required=true),
     *          @OA\Response(
     *          response="200",
     *          description="Ответ при успешном выполнении запроса",
     *          @OA\JsonContent(ref="#/components/schemas/show")
     *        )
     *      )
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $user = User::where('id', $id)->get()->load([
            'company',
            'city.country',
            'company',
            'position',
            'image',
            'preview',
            'resumes'
        ]);

        if (!collect($user)->isEmpty()) {
            return $this->successResponse($user[0]);
        } else {
            return $this->failureResponse(['message' => 'User not found.']);
        }
    }

}
