<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function successResponse($data, $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'response' => $data,
        ], $code);
    }

    protected function failureResponse($data, $code = 409): JsonResponse
    {
        return response()->json([
            'success' => false,
            'response' => $data,
        ], $code);
    }

    /**
     * Метод для пагинации.
     *
     * В него передаются посредством query perPage и page
     *
     * @param array $items - массив данных для пагинации
     * @return LengthAwarePaginator - пагинатор.
     */
    protected function paginate(array $items): LengthAwarePaginator
    {
        $perPage = request()->perPage ?: 10;
        $page = request()->page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);

        $currentItems = array_slice($items, $perPage * ($page - 1), $perPage);
        return new LengthAwarePaginator($currentItems, count($items), $perPage, $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]);
    }
}
