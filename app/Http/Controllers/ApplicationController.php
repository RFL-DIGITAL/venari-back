<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Services\ApplicationService;
class ApplicationController extends Controller
{

    public function __construct(protected ApplicationService $applicationService) {}


    /**
     * Метод получения всех откликов
     *
     * @OA\Schema( schema="getApplication",
     *               @OA\Property(property="success",type="boolean",example="true"),
     *               @OA\Property(property="response",type="array",
     *                    @OA\Items(ref="#/components/schemas/application")),
     *    )
     *
     * @OA\Get(
     *         path="/api/hr-panel/candidates/applications",
     *         tags={"HR-panel"},
     *     @OA\Parameter(
     *            name="vacancy_id",
     *           in="query",
     *            description="id вакансии",
     *            required=false),
     *         @OA\Response(
     *         response="200",
     *         description="Ответ при успешном выполнении запроса",
     *      @OA\JsonContent(ref="#/components/schemas/getApplication")
     *           )
     *     )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getApplication(Request $request): JsonResponse
    {

        $applications = $this->applicationService->getApplications($request->get('vacancy_id'));

        return $this->successResponse($applications);
    }

    /**
     * Метод получения подробного отклика
     *
     * @OA\Schema( schema="getApplicationByID",
     *                @OA\Property(property="success",type="boolean",example="true"),
     *                @OA\Property(property="response",type="array",
     *                     @OA\Items(ref="#/components/schemas/detailApplication")),
     *     )
     *
     * @OA\Get(
     *          path="/api/hr-panel/candidates/applications/{id}",
     *          tags={"HR-panel"},
     *      @OA\Parameter(
     *             name="id",
     *            in="path",
     *             description="id отклика",
     *             required=true),
     *          @OA\Response(
     *          response="200",
     *          description="Ответ при успешном выполнении запроса",
     *       @OA\JsonContent(ref="#/components/schemas/getApplicationByID")
     *            )
     *      )
     *
     * @param int $application_id
     * @return JsonResponse
     */
    public function getApplicationByID(int $application_id) {
        $applications = $this->applicationService->getApplicationByID($application_id);

        return $this->successResponse($applications);
    }

    /**
     * Метод получения пользователей для страницы поиска по кандидатам
     *
     * @OA\Schema( schema="getUsers",
     *                 @OA\Property(property="success",type="boolean",example="true"),
     *                 @OA\Property(property="response",type="array",
     *                      @OA\Items(ref="#/components/schemas/userWithResume")),
     *      )
     *
     * @OA\Get(
     *           path="/api/hr-panel/candidates/",
     *           tags={"HR-panel"},
     *       @OA\Parameter(
     *              name="experince_id",
     *             in="query",
     *              description="id требуемого опыта",
     *              required=false),
     *     @OA\Parameter(
     *               name="city",
     *              in="query",
     *               description="Региона поиска",
     *               required=false),
     *     @OA\Parameter(
     *               name="specialization_id",
     *              in="query",
     *               description="id необходимой специализации",
     *               required=false),
     *     @OA\Parameter(
     *               name="employment_id",
     *              in="query",
     *               description="id занятости",
     *               required=false),
     *     @OA\Parameter(
     *               name="program_type_id",
     *              in="query",
     *               description="id требуемого типа образования",
     *               required=false),
     *@OA\Parameter(
     *                name="higher_salary",
     *               in="query",
     *                description="верхнее допустимое значение зарплаты",
     *                required=false),
     *     @OA\Parameter(
     *                 name="lower_salary",
     *                in="query",
     *                 description="нижнее допустимое значение зарплаты",
     *                 required=false),
     *           @OA\Response(
     *           response="200",
     *           description="Ответ при успешном выполнении запроса",
     *        @OA\JsonContent(ref="#/components/schemas/getUsers")
     *             )
     *       )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getUsers(Request $request) {
        $city = City::where('name', $request->get('city'))->first();

        $users = $this->applicationService->getUsers(
            $request->get('experience_id'),
            $city?->id,
            $request->get('specialization_id'),
            $request->get('employment_id'),
            $request->get('program_type_id'),
            $request->get('higher_salary'),
            $request->get('lower_salary')
        );

        return $this->successResponse($users);

    }

}
