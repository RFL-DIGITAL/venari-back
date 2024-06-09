<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function successResponse($data, $code = 200)
    {
        return response()->json([
            'success' => true,
            'response' => $data,
        ], $code);
    }

    protected function failureResponse($data, $code = 409)
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
        $items = collect($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]);
    }
}
