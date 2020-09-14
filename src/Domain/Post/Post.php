<?php

declare(strict_types=1);

namespace SocialNetwork\Domain\Post;

use JsonSerializable;

class Post implements JsonSerializable
{
    private string $id;
    private Message $message;
    private string $type;
    private \DateTimeImmutable $createdAt;

    public function __construct(string $id, Message $message, string $type, \DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->message = $message;
        $this->type = $type;
        $this->createdAt = $createdAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'message' => (string)$this->getMessage(),
        ];
    }
}