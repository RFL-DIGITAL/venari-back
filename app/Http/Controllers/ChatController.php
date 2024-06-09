<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    public function __construct(protected ChatService $chatService)
    {
        $this->middleware('auth:api');
    }

    /**
     * Метод получения всех чатов пользователя. Отсортированы в обратном порядке по времени последнего сообщения
     * (самый поздний - первый)
     *
     * @OA\Schema( schema="getChats",
     *              @OA\Property(property="success",type="boolean",example="true"),
     *              @OA\Property(property="response",type="array",
     *                   @OA\Items(ref="#/components/schemas/previewChat")),
     *   )
     *
     * @OA\Get(
     *        path="/api/chats",
     *        tags={"ChatController"},
     *        @OA\Response(
     *        response="200",
     *        description="Ответ при успешном выполнении запроса",
     *        @OA\JsonContent(ref="#/components/schemas/getChats")
     *      )
     *    )
     *
     * @param $id
     * @return JsonResponse
     */
    public function getChats(Request $request): JsonResponse
    {
        $user_id = $request->user()->id;
        $recentChats = array_merge($this->chatService->formatOneToOnes($user_id),
            $this->chatService->formatGroups($user_id));

        // Перемешиваем, дабы групповые чаты не оставались внизу
        shuffle($recentChats);

        // Сортируем чаты - последний самый верхний
        usort($recentChats, function ($a, $b) {
            return $a->getUpdatedAt() < $b->getUpdatedAt();
        });

        return $this->successResponse(
            $this->paginate($recentChats)
        );
    }

    /**
     * Метод получения сообщений 1-1 по id пользователя
     *
     * @OA\Schema( schema="getMessagesByUserID",
     *               @OA\Property(property="success",type="boolean",example="true"),
     *               @OA\Property(property="response",type="array",
     *                    @OA\Items(ref="#/components/schemas/message")),
     *    )
     *
     * @OA\Get(
     *         path="/api/chats/personal/{userID}",
     *         tags={"ChatController"},
     *      @OA\Parameter(
     *           name="userID",
     *           description="id пользователя",
     *           required=true),
     *         @OA\Response(
     *         response="200",
     *         description="Ответ при успешном выполнении запроса",
     *         @OA\JsonContent(ref="#/components/schemas/getMessagesByUserID")
     *       )
     *     )
     *
     * @param Request $request - запрос
     * @param $userID - id пользователя, сообщения с которым нужно получить
     * @return JsonResponse
     */
    public function getMessagesByUserID(Request $request, $userID): JsonResponse
    {
        return $this->successResponse(
            $this->paginate(
                $this->chatService->getMessagesByUserID($request->user()->id, $userID)
            )
        );
    }

    /**
     * Метод получения сообщений чата по id чата
     *
     * @OA\Schema( schema="getChatMessagesByChatID",
     *                @OA\Property(property="success",type="boolean",example="true"),
     *                @OA\Property(property="response",type="array",
     *                     @OA\Items(ref="#/components/schemas/chatMessage")),
     *     )
     *
     * @OA\Get(
     *          path="/api/chats/group/{chatID}",
     *          tags={"ChatController"},
     *       @OA\Parameter(
     *            name="chatID",
     *            description="id чата",
     *            required=true),
     *          @OA\Response(
     *          response="200",
     *          description="Ответ при успешном выполнении запроса",
     *          @OA\JsonContent(ref="#/components/schemas/getChatMessagesByChatID")
     *        )
     *      )
     *
     * @param $chatID - id чата
     * @return JsonResponse
     */
    public function getChatMessagesByChatID($chatID): JsonResponse
    {
        return $this->successResponse(
            $this->paginate(
                $this->chatService->getChatMessagesByChatID($chatID)
            )
        );
    }
}
