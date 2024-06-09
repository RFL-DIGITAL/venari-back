<?php

namespace App\Http\Controllers;

use App\Services\VacancyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

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
}
