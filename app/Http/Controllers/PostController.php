<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Services\CommentService;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    private int $POST_COUNT = 10;

    public function __construct(protected PostService $postService, protected CommentService $commentService)
    {
    }


    /**
     * Метод получения всех постов
     *
     * @OA\Schema( schema="getPosts",
     *              @OA\Property(property="success",type="boolean",example="true"),
     *              @OA\Property(property="response",type="array",
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

        if (request()->get('force_outer')) {
           $outerPosts = [];
        }
        else {
            if (Cache::has('outer_posts')) {
                $outerPosts = Cache::get('outer_posts');
            } else {
                $outerPosts = $this->postService->getOuterPosts($this->POST_COUNT);
                Cache::put('outer_posts', $outerPosts, now()->addMinutes(15));
            }
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
     *               @OA\Property(property="response", ref="#/components/schemas/detailPost"),
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

    /**
     * Метод получения постов по id пользователя
     *
     * @OA\Schema( schema="getPostsByUser",
     *                @OA\Property(property="success",type="boolean",example="true"),
     *                @OA\Property(property="response", ref="#/components/schemas/post"),
     *     )
     *
     * @OA\Get(
     *          path="/api/users/{id}/posts",
     *          tags={"PostController"},
     *      @OA\Parameter(
     *           name="id",
     *      in="path",
     *           description="id поста",
     *           required=true),
     *          @OA\Response(
     *          response="200",
     *          description="Ответ при успешном выполнении запроса",
     *          @OA\JsonContent(ref="#/components/schemas/getPostsByUser")
     *        )
     *      )
     *
     * @param $id
     * @return JsonResponse
     */
    public function getPostsByUser($id): JsonResponse
    {
        return $this->successResponse(
            $this->paginate(
                $this->postService->getPostByUserID($id)
            )
        );
    }

    /**
     * Метод получения постов по id компании
     *
     * @OA\Schema( schema="getPostsByCompany",
     *                @OA\Property(property="success",type="boolean",example="true"),
     *                @OA\Property(property="response", ref="#/components/schemas/post"),
     *     )
     *
     * @OA\Get(
     *          path="/api/companies/{id}/posts",
     *          tags={"PostController"},
     *      @OA\Parameter(
     *           name="id",
     *      in="path",
     *           description="id компании",
     *           required=true),
     *          @OA\Response(
     *          response="200",
     *          description="Ответ при успешном выполнении запроса",
     *          @OA\JsonContent(ref="#/components/schemas/getPostsByCompany")
     *        )
     *      )
     *
     * @param $id
     * @return JsonResponse
     */
    public function getPostsByCompany($id): JsonResponse
    {
        return $this->successResponse(
            $this->paginate(
                $this->postService->getPostByCompanyID($id)
            )
        );
    }

    /**
     * Метод получения всех комментариев поста
     *
     * @OA\Schema( schema="getComments",
     *              @OA\Property(property="success",type="boolean",example="true"),
     *              @OA\Property(property="response",type="array",
     *                   @OA\Items(ref="#/components/schemas/detailComment")),
     *   )
     *
     * @OA\Get(
     *        path="/api/posts/{id}/comments",
     *        tags={"CommentController"},
     *     @OA\Parameter(
     *           name="id",
     *              in="path",
     *           description="id поста",
     *           required=true),
     *        @OA\Response(
     *        response="200",
     *        description="Ответ при успешном выполнении запроса",
     *        @OA\JsonContent(ref="#/components/schemas/getComments")
     *      )
     *    )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getComments(int $id): JsonResponse
    {
        return $this->successResponse(
            $this->paginate(
                $this->commentService->getComments($id)
            )
        );
    }

    public function createPost(): JsonResponse
    {
        return $this->successResponse(
            $this->postService->createPost(
                request()->post_parts,
                request()->category_id,
                request()->title
            )
        );
    }
}
