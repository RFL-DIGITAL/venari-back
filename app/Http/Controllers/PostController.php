<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private int $POST_COUNT = 10;

    public function __construct(protected PostService $postService) {}


    /**
     * Метод получения всех постов
     *
     * @OA\Schema( schema="getPosts",
     *              @OA\Property(property="success",type="boolean",example="true"),
     *              @OA\Property(property="posts",type="array",
     *                   @OA\Items(ref="#/components/schemas/post")),
     *   )
     *
     * @OA\Get(
     *        path="/api/posts",
     *        tags={"PostController"},
     *        @OA\Response(
     *        response="200",
     *        description="Ответ при успешном выполнении запроса",
     *        @OA\JsonContent(ref="#/components/schemas/getPosts")
     *      )
     *    )
     *
     * @return JsonResponse
     */
    public function getPosts(): JsonResponse
    {
        $innerPosts = $this->postService->getInnerPosts();

        if(Cache::has('outer_posts')) {
            $outerPosts = Cache::get('outer_posts');
        }
        else {
            $outerPosts = $this->postService->getOuterPosts($this->POST_COUNT);
            Cache::put('outer_posts', $outerPosts, now()->addMinutes(15));
        }

        $posts = array_merge(
            $innerPosts,
            $outerPosts
        );

        shuffle($posts);
        return $this->successResponse(
            $this->paginate($posts)
        );
    }

    /**
     * Метод получения поста по его id (подробная страница)
     *
     * @OA\Schema( schema="getPostByID",
     *               @OA\Property(property="success",type="boolean",example="true"),
     *               @OA\Property(property="post", ref="#/components/schemas/post"),
     *    )
     *
     * @OA\Get(
     *         path="/api/posts/{id}",
     *         tags={"PostController"},
     *     @OA\Parameter(
     *          name="id",
     *     in="path",
     *          description="id поста",
     *          required=true),
     *         @OA\Response(
     *         response="200",
     *         description="Ответ при успешном выполнении запроса",
     *         @OA\JsonContent(ref="#/components/schemas/getPostByID")
     *       )
     *     )
     *
     * @param $id - id поста
     * @return JsonResponse
     */
    public function getPostByID($id): JsonResponse
    {
        return $this->successResponse(
            $this->postService->getPostByID($id)
        );
    }

}
