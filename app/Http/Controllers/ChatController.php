<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    public function __construct(protected ChatService $chatService)
    {
    }

    /**
     * Метод получения всех чатов (страница нетворкинг)
     *
     * @OA\Schema( schema="getAllChats",
     *                @OA\Property(property="success",type="boolean",example="true"),
     *                @OA\Property(property="response",type="array",
     *                     @OA\Items(ref="#/components/schemas/chat")),
     *     )
     *
     * @OA\Get(
     *          path="/api/networking/",
     *          tags={"СhatController"},
     *          @OA\Response(
     *          response="200",
     *          description="Ответ при успешном выполнении запроса",
     *          @OA\JsonContent(ref="#/components/schemas/getAllChats")
     *        )
     *      )
     *
     * @param $chatID - id чата
     * @return JsonResponse
     */
    public function getAllChats(): JsonResponse
    {
        return $this->successResponse(
            $this->paginate(
                $this->chatService->getAllChats()
            )
        );
    }

    /**
     * Метод получения сообщений чата по id чата
     *
     * @OA\Schema( schema="getChatMessagesByChatID",
     *                @OA\Property(property="success",type="boolean",example="true"),
     *                @OA\Property(property="response",type="array",
     *                     @OA\Items(ref="#/components/schemas/messageDTO")),
     *     )
     *
     * @OA\Get(
     *          path="/api/networking/{chatID}/messages",
     *          tags={"СhatController"},
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

    /**
     * Метод получения подробной информации о чате по id
     *
     * @OA\Schema( schema="getChatDetail",
     *                @OA\Property(property="success",type="boolean",example="true"),
     *                @OA\Property(property="response",type="array",
     *                     @OA\Items(ref="#/components/schemas/chat")),
     *     )
     *
     * @OA\Get(
     *          path="/api/networking/{chatID}",
     *          tags={"СhatController"},
     *       @OA\Parameter(
     *            name="chatID",
     *            description="id чата",
     *            required=true),
     *          @OA\Response(
     *          response="200",
     *          description="Ответ при успешном выполнении запроса",
     *          @OA\JsonContent(ref="#/components/schemas/getChatDetail")
     *        )
     *      )
     *
     * @param $chatID - id чата
     * @return JsonResponse
     */
    public function getChatDetail($chatID): JsonResponse
    {
        return $this->successResponse(
            $this->chatService->getChatDetail($chatID)
        );
    }
}
