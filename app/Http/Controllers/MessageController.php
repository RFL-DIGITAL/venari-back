<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function __construct(protected MessageService $messageService) {}

    /**
     * Метод отправки сообщений
     *
     * @OA\Schema( schema="sendMessage",
     *                @OA\Property(property="success",type="boolean",example="true"),
     *                @OA\Property(property="response",type="array",
     *                     @OA\Items(ref="#/components/schemas/message")),
     *     )
     *
     * @OA\Post(
     *          path="/api/messages/send-message",
     *          tags={"MessageController"},
     *      @OA\Parameter(
     *            description="id отправителя. Это id пользователя",
     *            name="ownerID",
     *            type="int",
     *       ),
     *     @OA\Parameter(
     *             description="id получателя. Это ЛИБО id пользователя ЛИБО id чата",
     *             name="toID",
     *             type="int",
     *        ),
     *     @OA\Parameter(
     *              description="текст сообщения",
     *              name="body",
     *              type="string",
     *         ),
     *     @OA\Parameter (
     *               description="Тип сообщения, которое должно быть отправлено. ЛИБО message, для 1-1, ЛИБО chatMessage, если это сообщение в чат",
     *               name="type",
     *               type="string",
     *          ),
     *
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
}
