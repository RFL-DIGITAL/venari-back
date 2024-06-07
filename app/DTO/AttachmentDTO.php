<?php

namespace App\DTO;

use App\Models\File;
use App\Models\Image;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class AttachmentDTO implements Jsonable, JsonSerializable
{
    public function __construct(
        private ?string $text,
        private ?File   $file,
        private ?Image  $image,
        private ?string $link,
    ) {}

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
            'file' => $this->file->file,
            'image' => $this->image->image,
            'link' => $this->link
        ];
    }
}
