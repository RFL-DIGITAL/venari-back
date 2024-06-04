<?php

namespace App\Http\Controllers;

use App\Services\VacanciesService;
use Illuminate\Http\Request;

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
        $vacancies = array_merge(
            $this->vacanciesService->getOuterVacancies(),
            $this->vacanciesService->getInnerVacancies()
        );

        shuffle($vacancies);

        return $this->successResponse(json_encode([
            $vacancies
        ]));
    }
}
