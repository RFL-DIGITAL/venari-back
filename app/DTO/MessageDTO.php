<?php

namespace App\DTO;

use App\Models\User;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class MessageDTO implements Jsonable, JsonSerializable
{
    public function __construct(
        private int           $id,
        private int           $owner_id,
        private string        $to_id,
        private User          $owner,
        private AttachmentDTO $attachmentDTO,
    ) {
        $owner->load('image');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getOwnerId(): int
    {
        return $this->owner_id;
    }

    public function setOwnerId(int $owner_id): void
    {
        $this->owner_id = $owner_id;
    }

    public function getToId(): string
    {
        return $this->to_id;
    }

    public function setToId(string $to_id): void
    {
        $this->to_id = $to_id;
    }

    public function getAttachmentDTO(): AttachmentDTO
    {
        return $this->attachmentDTO;
    }

    public function setAttachmentDTO(AttachmentDTO $attachmentDTO): void
    {
        $this->attachmentDTO = $attachmentDTO;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize());
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'to_id' => $this->to_id,
            'owner' => $this->owner,
            'attachments' => $this->attachmentDTO,
        ];
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }
}
