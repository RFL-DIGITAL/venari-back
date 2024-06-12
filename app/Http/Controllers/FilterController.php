<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use App\Models\Experience;
use App\Models\Format;
use App\Models\Specialization;
use App\Models\Status;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    /**
     * Метод получения всех доступных фильтров
     *
     * @OA\Schema( schema="getAllFilters",
     *              @OA\Property(property="success",type="boolean",example="true"),
     *              @OA\Property(property="response",type="array",
     *                   @OA\Items(ref="#/components/schemas/filter")),
     *   )
     *
     * @OA\Get(
     *        path="/api/hr-panel/filters",
     *        tags={"HR-panel"},
     *        @OA\Response(
     *        response="200",
     *        description="Ответ при успешном выполнении запроса",
     *        @OA\JsonContent(ref="#/components/schemas/getAllFilters")
     *      )
     *    )
     *
     * @return array
     */
    public function getAllFilters(): array
    {
        return [
            'statuses' => Status::all()->toArray(),
            'employments' => Employment::all()->toArray(),
            'experiences' => Experience::all()->toArray(),
            'formats' => Format::all()->toArray(),
            'specializations' => Specialization::all()->toArray(),
        ];
    }
}
