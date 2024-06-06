<?php

namespace App\DTO;

enum MessageType: string
{
    case message = 'message';
    case chatMessage = 'chatMessage';
}
