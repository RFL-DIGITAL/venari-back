<?php

namespace App\DTO;

use App\Models\File;
use App\Models\Image;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

/** @OA\Schema(schema="attachmentDTO") */
class AttachmentDTO implements Jsonable, JsonSerializable
{
    /**
     * @OA\Property()
     */
    private ?string $text;

    /**
     * @OA\Property(type="string")
     */
    private ?string $file;

    /**
     * @OA\Property(type="string")
     */
    private ?string $image;

    /**
     * @OA\Property()
     */
    private ?string $link;

    public function __construct(
        ?string $text,
        ?string   $file,
        ?string  $image,
        ?string $link,
    ) {
        $this->link = $link;
        $this->image = $image;
        $this->file = $file;
        $this->text = $text;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): void
    {
        $this->file = $file;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize());
    }

    public function jsonSerialize(): mixed
    {
        return [
            'text' => $this->text,
            'file' => $this->file,
            'image' => $this->image,
            'link' => $this->link
        ];
    }
}
