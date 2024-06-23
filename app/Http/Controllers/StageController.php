<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Stage;

class StageController extends Controller
{
    private const REKSOFT_COMPANY_ID = 1;

    /**
     * Метод получения всех "категорий" для откликов
     *
     * @OA\Schema( schema="getStages",
     *               @OA\Property(property="success",type="boolean",example="true"),
     *               @OA\Property(property="response",type="array",
     *                    @OA\Items(ref="#/components/schemas/stage")),
     *    )
     *
     * @OA\Get(
     *         path="/api/hr-panel/candidates/stages",
     *         tags={"HR-panel"},
     *         @OA\Response(
     *         response="200",
     *         description="Ответ при успешном выполнении запроса",
     *      @OA\JsonContent(ref="#/components/schemas/getStages")
     *           )
     *     )
     *
     * @return JsonResponse
     */
    public function getStages() {
        $stages = Stage::where('company_id', $this::REKSOFT_COMPANY_ID)->get()
            ->load([
                'stageType'
            ])->toArray();
        if (!collect($stages)->isEmpty()) {
            return $this->successResponse($stages);
        } else {
            return $this->failureResponse($stages);
        }
    }

}
