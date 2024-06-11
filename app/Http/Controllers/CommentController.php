<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct(protected CommentService $commentService)
    {
    }

    /**
     * Метод отправки комментария
     *
     * @OA\Schema( schema="sendComment",
     *                 @OA\Property(property="success",type="boolean",example="true"),
     *                 @OA\Property(property="response",type="array",
     *                      @OA\Items(ref="#/components/schemas/comment")),
     *      )
     *
     * @OA\Post(
     *           path="/api/comments/send-comment",
     *           tags={"CommentController"},
     *           @OA\RequestBody(ref="#/components/requestBodies/SendCommentRequest"),
     *           @OA\Response(
     *           response="200",
     *           description="Ответ при успешном выполнении запроса",
     *           @OA\JsonContent(ref="#/components/schemas/sendComment")
     *         )
     *       )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendComment(Request $request): JsonResponse
    {
        $userID = auth()->id();

        if ($request->exists('parent_id')) {
            return $this->successResponse(
                $this->commentService->addComment(
                    $userID,
                    $request->text,
                    $request->post_id,
                    $request->parent_id,
                )
            );
        }
        return $this->successResponse(
            $this->commentService->addComment(
                $userID,
                $request->text,
                $request->post_id,
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
}
