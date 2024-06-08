<?php

namespace App\DTO;

use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class ChatPreviewDTO implements Jsonable, JsonSerializable
{
    public function __construct(
        private string $name,
        private string $avatar,
        private ?string $body,
        private ?string $updated_at,
        private MessageType $type,
        private int $id,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize());
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'avatar' => $this->avatar,
            'body' => $this->body,
            'updated_at' => $this->updated_at,
            'type' => $this->type,
            'id' => $this->id,
        ];
    }

    public function getType(): MessageType
    {
        return $this->type;
    }

    public function setType(MessageType $type): void
    {
        $this->type = $type;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
