<?php

namespace App\DTO;

/** @OA\Schema(schema="messageType") */
enum MessageType: string
{
    case message = 'message';
    case chatMessage = 'chatMessage';
    case companyMessage = 'companyMessage';
}
