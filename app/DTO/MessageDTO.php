<?php

namespace App\DTO;

use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

/** @OA\Schema(schema="messageDTO") */
class MessageDTO implements Jsonable, JsonSerializable
{
    /**
     * @OA\Property()
     */
    private int $id;

    /**
     * @OA\Property()
     */
    private int $owner_id;

    /**
     * @OA\Property(description="либо id пользователя, либо id чата, либо id чата компании")
     */
    private string $to_id;

    /**
     * @OA\Property(ref="#/components/schemas/detailUser")
     */
    private User|null $owner;

    /**
     * @OA\Property()
     */
    private AttachmentDTO $attachmentDTO;

    /**
     * @OA\Property(format="date")
     */
    private string $created_at;

    public function __construct(
        int           $id,
        int           $owner_id,
        string        $to_id,
        User|null          $owner,
        AttachmentDTO $attachmentDTO,
        string        $created_at
    ) {
        $this->created_at = $created_at;
        $this->attachmentDTO = $attachmentDTO;
        $this->owner = $owner;
//        $this->owner->load('image');
        $this->to_id = $to_id;
        $this->owner_id = $owner_id;
        $this->id = $id;
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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'ownerId' => $this->owner_id,
            'toId' => $this->to_id,
            'owner' => $this->owner,
            'attachments' => $this->attachmentDTO,
            'createdAt' => $this->created_at
        ];
    }

    public function getOwner(): User|null
    {
        return $this?->owner;
    }

    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }
}
