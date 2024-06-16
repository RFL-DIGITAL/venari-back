<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassVacanciesRequest;
use App\Http\Requests\SendApproveRequest;
use App\Http\Requests\ShareApplicationsRequest;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Services\ApplicationService;

class ApplicationController extends Controller
{

    public function __construct(protected ApplicationService $applicationService)
    {
    }


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
     *             name="stage_id",
     *            in="query",
     *             description="id категории. Для категории Все кандидаты не отправлять этот параметр",
     *             required=false),
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
        $applications = $this->applicationService->getApplications(
            $request->get('stage_id'),
            $request->get('vacancy_id')
        );

        if (!empty($applications)) {
            return $this->successResponse(
                $this->paginate($applications)
            );
        } else {
            return $this->failureResponse(
                ['message' => 'Applications not found']
            );
        }

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
    public function getApplicationByID(int $application_id)
    {
        $application = $this->applicationService->getApplicationByID($application_id);

        return $this->successResponse($application);
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
    public function getUsers(Request $request)
    {
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

        return $this->successResponse(
            $this->paginate($users)
        );

    }

    /**
     * Метод шэринга откликов
     *
     * @OA\Schema( schema="shareApplications",
     *                  @OA\Property(property="success",type="boolean",example="true"),
     *                  @OA\Property(property="response",type="array",
     *                       @OA\Items(ref="#/components/schemas/link")),
     *       )
     *
     * @OA\Schema( schema="link",
     *                   @OA\Property(property="link",type="string"),
     *        )
     *
     * @OA\Post(
     *              path="/api/hr-panel/candidates/applications/share-applications",
     *              tags={"HR-panel"},
     *              @OA\RequestBody(ref="#/components/requestBodies/ShareApplicationsRequest"),
     *              @OA\Response(
     *              response="200",
     *              description="Ответ при успешном выполнении запроса",
     *              @OA\JsonContent(ref="#/components/schemas/shareApplications")
     *            )
     *          )
     *
     * @param ShareApplicationsRequest $request
     * @return JsonResponse
     */
    public function shareApplications(ShareApplicationsRequest $request): JsonResponse
    {
        return $this->successResponse(
            $this->applicationService->shareApplications($request->application_ids)
        );
    }

    /**
     * Метод получения пользователей для страницы отображения всех апрувов
     *
     * @OA\Schema( schema="getApplicationsByGroupCode",
     *                 @OA\Property(property="success",type="boolean",example="true"),
     *                 @OA\Property(property="response",type="array",
     *                      @OA\Items(ref="#/components/schemas/userWithResumeAndApplication")),
     *      )
     *
     * @OA\Get(
     *           path="/api/variants/see-variants/{code}",
     *           tags={"Approves"},
     *     @OA\Parameter(
     *                 name="code",
     *                in="path",
     *                 description="код для просмотра откликов для подтверждения",
     *                 required=false),
     *           @OA\Response(
     *           response="200",
     *           description="Ответ при успешном выполнении запроса",
     *        @OA\JsonContent(ref="#/components/schemas/getApplicationsByGroupCode")
     *             )
     *       )
     *
     * @param $code
     * @return JsonResponse
     */
    public function getApplicationsByGroupCode($code): JsonResponse
    {
        return $this->successResponse(
            $this->applicationService->getApplicationsByGroupCode($code)
        );
    }


    /**
     * Метод отправки апрува
     *
     * @OA\Schema( schema="sendApprove",
     *                  @OA\Property(property="success",type="boolean",example="true"),
     *                  @OA\Property(property="response",type="array",
     *                       @OA\Items(ref="#/components/schemas/approve")),
     *       )
     *
     *
     * @OA\Post(
     *              path="/api/hr-panel/variants/sendApprove",
     *              tags={"Approves"},
     *              @OA\RequestBody(ref="#/components/requestBodies/SendApproveRequest"),
     *              @OA\Response(
     *              response="200",
     *              description="Ответ при успешном выполнении запроса",
     *              @OA\JsonContent(ref="#/components/schemas/sendApprove")
     *            )
     *          )
     *
     * @param SendApproveRequest $request
     * @return JsonResponse
     */
    public function sendApprove(SendApproveRequest $request): JsonResponse
    {
        return $this->successResponse(
            $this->applicationService->sendApprove(
                $request->get('application_id'),
                $request->get('name'),
                $request->get('surname'),
                $request->get('is_approved'),
                $request->get('comment'),
            )
        );
    }

    public function changeStage(Request $request): JsonResponse
    {
        return $this->successResponse(
            $this->applicationService->changeStage(
                $request->get('stage_id'),
                $request->get('application_ids'),
                $request->user()->id,
                $request->get('reject_reason_id'),
                $request->get('is_send_reject_message'),
                $request->get('reject_message'),
                $request->get('interview_message'),
                $request->get('offer_message'),
            )
        );
    }

    public function apply(Request $request) {
        return $this->successResponse(
            $this->applicationService->apply(
                $request->user()->id,
                $request->get('vacancy_id')
            )
        );
    }

}
