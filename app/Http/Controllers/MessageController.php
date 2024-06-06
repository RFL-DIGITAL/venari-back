<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function __construct(protected MessageService $messageService) {}

    public function sendMessage(Request $request): JsonResponse
    {
        return $this->successResponse(
            $this->messageService->sendMessage($request));
    }
}
