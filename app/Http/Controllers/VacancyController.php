<?php

namespace App\Http\Controllers;

use App\Services\VacancyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function __construct(protected VacancyService $vacancyService){}

    /**
     * Метод получения всех вакансий
     *
     * @OA\Schema( schema="getVacancies",
     *             @OA\Property(property="success",type="boolean",example="true"),
     *             @OA\Property(property="response",type="array",
     *                  @OA\Items(ref="#/components/schemas/vacancy")),
     *  )
     *
     * @OA\Get(
     *       path="/api/vacancies",
     *       tags={"VacancyController"},
     *       @OA\Response(
     *       response="200",
     *       description="Ответ при успешном выполнении запроса",
     *       @OA\JsonContent(ref="#/components/schemas/getVacancies")
     *     )
     *   )
     *
     *
     * @return JsonResponse
     */
    public function getVacancies(): JsonResponse
    {
        $innerVacancies = $this->vacancyService->getInnerVacancies();

        if(Cache::has('outer_vacancies')) {
            $outerVacancies = Cache::get('outer_vacancies');
        }
        else {
            $outerVacancies = $this->vacancyService->getOuterVacancies();
            Cache::put('outer_vacancies', $outerVacancies, now()->addMinutes(15));
        }


        $vacancies = array_merge(
            $innerVacancies,
            $outerVacancies
        );

        shuffle($vacancies);

        return $this->successResponse(
            $this->paginate($vacancies)
        );
    }

    /**
     * Метод получения подробной информации о вакансии по id
     *
     * @OA\Schema( schema="getVacancyByID",
     *              @OA\Property(property="success",type="boolean",example="true"),
     *              @OA\Property(property="response",type="array",
     *                   @OA\Items(ref="#/components/schemas/detailVacancy")),
     *   )
     *
     * @OA\Get(
     *        path="/api/vacancies/{id}",
     *        tags={"VacancyController"},
     *     @OA\Parameter(
     *           name="id",
     *          in="path",
     *           description="id вакансии",
     *           required=true),
     *        @OA\Response(
     *        response="200",
     *        description="Ответ при успешном выполнении запроса",
     *     @OA\JsonContent(ref="#/components/schemas/getVacancyByID")
 *          )
     *    )
     *
     * @param int $id - id вакансии
     * @return JsonResponse
     */
    public function getVacancyByID(int $id): JsonResponse
    {
        return $this->successResponse($this->vacancyService->getVacancyByID($id));
    }

    /**
     * Метод получения всех вакансий для hr-панели
     *
     * @OA\Schema( schema="getVacanciesHR",
     *             @OA\Property(property="success",type="boolean",example="true"),
     *             @OA\Property(property="response",type="array",
     *                  @OA\Items(ref="#/components/schemas/detailVacancy")),
     *  )
     *
     * @OA\Get(
     *       path="/api/hr-panel/vacancies",
     *       tags={"HR-panel"},
     *     @OA\Parameter(
     *            name="status_id",
     *           in="query",
     *            description="id статуса (открыта, черновик, архив)",
     *            required=false),
     *     @OA\Parameter(
     *             name="specialization_id",
     *            in="query",
     *             description="id специализации",
     *             required=false),
     *       @OA\Response(
     *       response="200",
     *       description="Ответ при успешном выполнении запроса",
     *       @OA\JsonContent(ref="#/components/schemas/getVacanciesHR")
     *     )
     *   )
     *
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getVacanciesHR(Request $request): JsonResponse
    {
        $statusID = $request->query('status_id');
        $specializationID = $request->query('specialization_id');

        $innerVacancies = $this->vacancyService->getInnerVacanciesHR($statusID, $specializationID);

        return $this->successResponse(
            $this->paginate($innerVacancies)
        );
    }
}
