<?php

namespace App\Http\Controllers;

use App\Services\VacanciesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VacanciesController extends Controller
{
    public function __construct(protected VacanciesService $vacanciesService){}

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
     *       tags={"VacanciesController"},
     *       @OA\Response(
     *       response="200",
     *       description="Ответ при успешном выполнении запроса",
     *       @OA\JsonContent(ref="#/components/schemas/getVacancies")
     *     )
     *   )
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVacancies() {
        if(Cache::has('actual_vacancies')) {
            return $this->successResponse(Cache::get('actual_vacancies'));
        }
        $vacancies = array_merge(
            $this->vacanciesService->getOuterVacancies(),
            $this->vacanciesService->getInnerVacancies()
        );

        shuffle($vacancies);

        Cache::put('actual_vacancies', $vacancies, now()->addMinutes(15));

        return $this->successResponse($vacancies);
    }
}
