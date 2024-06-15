<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{

    /**
     * Метод получения информации о компании по её id
     *
     * @OA\Schema( schema="showCompany",
     *                @OA\Property(property="success",type="boolean",example="true"),
     *                @OA\Property(property="response", ref="#/components/schemas/detailCompany"),
     *     )
     *
     * @OA\Get(
     *          path="/api/companies/{id}",
     *          tags={"CompanyController"},
     *      @OA\Parameter(
     *           name="id",
     *      in="path",
     *           description="id компании",
     *           required=true),
     *          @OA\Response(
     *          response="200",
     *          description="Ответ при успешном выполнении запроса",
     *          @OA\JsonContent(ref="#/components/schemas/showCompany")
     *        )
     *      )
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $data = Company::where('id', $id)->get()->load([
            'building.street.city.country',
            'image',
            'preview'
        ])->toArray();

        if (!collect($data)->isEmpty()) {
            return $this->successResponse($data[0]);
        }

        return $this->failureResponse(['message' => 'Company not found.']);
    }

}
