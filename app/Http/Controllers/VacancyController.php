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
     *             @OA\Property(property="vacancies",type="array",
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

        return $this->successResponse($vacancies);
    }
}