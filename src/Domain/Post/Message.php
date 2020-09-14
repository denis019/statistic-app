<?php

declare(strict_types=1);

namespace SocialNetwork\Domain\Post;

final class Message implements \Stringable
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getLength(): int
    {
        return strlen($this->message);
    }

    public function __toString()
    {
        return $this->message;
    }
}