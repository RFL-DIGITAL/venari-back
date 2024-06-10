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
    private ?File $file;

    /**
     * @OA\Property(type="string")
     */
    private ?Image $image;

    /**
     * @OA\Property()
     */
    private ?string $link;

    public function __construct(
        ?string $text,
        ?File   $file,
        ?Image  $image,
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

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): void
    {
        $this->file = $file;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): void
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
            'file' => $this->file?->file,
            'image' => $this->image?->image,
            'link' => $this->link
        ];
    }
}
