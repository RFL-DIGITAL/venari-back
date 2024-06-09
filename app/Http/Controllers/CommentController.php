<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
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
     * @return array
     */
    public function sendComment(Request $request): array
    {
        $userID = auth()->id();

        if ($request->exists('parentID')) {
            return $this->commentService->addComment(
                $userID,
                $request->text,
                $request->postID,
                $request->parentID,
            );
        }
        return $this->commentService->addComment(
            $userID,
            $request->text,
            $request->postID,
        );
    }
}
