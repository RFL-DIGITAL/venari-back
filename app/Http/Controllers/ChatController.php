<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    public function __construct(protected ChatService $chatService) {}

    public function getChats($id): JsonResponse
    {
        $user_id = $id;

        $recentChats = array_merge( $this->chatService->formatOneToOnes($user_id),
            $this->chatService->formatGroups($user_id));
        // Перемешиваем, дабы групповые чаты не оставались внизу
        shuffle($recentChats);

        // Сортируем чаты - последний самый верхний
        usort($recentChats, function($a, $b)
        {
            return $a->getUpdatedAt() < $b->getUpdatedAt();
        });

        return $this->successResponse($recentChats);
    }

    public function getMessagesByUserID(Request $request, $userID): JsonResponse
    {
        return $this->successResponse(
            $this->chatService->getMessagesByUserID($request->user()->id, $userID)
        );
    }

    public function getChatMessagesByChatID($chatID): JsonResponse
    {
        return $this->successResponse(
            $this->chatService->getChatMessagesByChatID($chatID)
        );
    }
}
