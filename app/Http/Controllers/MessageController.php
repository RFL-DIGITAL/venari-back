<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function __construct(protected ChatService $chatService, protected MessageService $messageService)
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
     *        path="/api/messages",
     *        tags={"MessageController"},
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
     *                    @OA\Items(ref="#/components/schemas/messageDTO")),
     *    )
     *
     * @OA\Get(
     *         path="/api/messages/{user_id}",
     *         tags={"MessageController"},
     *      @OA\Parameter(
     *           name="user_id",
     *              in="path",
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
     * @param $user_id - id пользователя, сообщения с которым нужно получить
     * @return JsonResponse
     */
    public function getMessagesByUserID(Request $request, $user_id): JsonResponse
    {
        return $this->successResponse(
            $this->paginate(
                $this->chatService->getMessagesByUserID($request->user()->id, $user_id)
            )
        );
    }

    /**
     * Метод отправки сообщений
     *
     * @OA\Schema( schema="sendMessage",
     *                @OA\Property(property="success",type="boolean",example="true"),
     *                @OA\Property(property="response",type="array",
     *                     @OA\Items(ref="#/components/schemas/messageDTO")),
     *     )
     *
     * @OA\Post(
     *          path="/api/messages/send-message",
     *          tags={"MessageController"},
     *          @OA\RequestBody(ref="#/components/requestBodies/SendMessageRequest"),
     *          @OA\Response(
     *          response="200",
     *          description="Ответ при успешном выполнении запроса",
     *          @OA\JsonContent(ref="#/components/schemas/sendMessage")
     *        )
     *      )
     *
     * @param Request $request - запрос
     * @return JsonResponse
     */
    public function sendMessage(Request $request): JsonResponse
    {
        return $this->successResponse(
            $this->messageService->sendMessage($request));
    }

    /**
     * Метод вступления в чат
     *
     * @OA\Schema( schema="joinChat",
     *                 @OA\Property(property="success",type="boolean",example="true"),
     *                 @OA\Property(property="response",type="array",
     *                      @OA\Items(ref="#/components/schemas/chat")),
     *      )
     *
     * @OA\Post(
     *           path="/api/messages/join-chat",
     *           tags={"MessageController"},
     *           @OA\RequestBody(ref="#/components/requestBodies/JoinChatRequest"),
     *           @OA\Response(
     *           response="200",
     *           description="Ответ при успешном выполнении запроса",
     *           @OA\JsonContent(ref="#/components/schemas/joinChat")
     *         )
     *       )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function joinChat(Request $request): JsonResponse
    {
        return $this->successResponse(
            $this->chatService->joinChat(
                auth()->id(),
                $request->chat_id
            )
        );
    }

    /**
     * Метод покидания чата
     *
     * @OA\Schema(schema="quitChat",
     *                 @OA\Property(property="success",type="boolean",example="true"),
     *                 @OA\Property(property="response",type="array",
     *                      @OA\Items(ref="#/components/schemas/chat")),
     *      )
     *
     * @OA\Post(
     *           path="/api/messages/quit-chat",
     *           tags={"MessageController"},
     *           @OA\RequestBody(ref="#/components/requestBodies/JoinChatRequest"),
     *           @OA\Response(
     *           response="200",
     *           description="Ответ при успешном выполнении запроса",
     *           @OA\JsonContent(ref="#/components/schemas/joinChat")
     *         )
     *       )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function quitChat(Request $request): JsonResponse
    {
        return $this->successResponse(
            $this->chatService->quitChat(
                auth()->id(),
                $request->chat_id
            )
        );
    }
}
