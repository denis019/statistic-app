<?php

declare(strict_types=1);

namespace SocialNetwork\Domain\Post;

final class PostFactory
{
    const DATE_TIME_FORMAT = 'Y-m-d\TH:i:sP';

    public static function create(
        string $id,
        string $message,
        string $type,
        string $createdAt
    ): Post
    {
        return new Post(
            $id,
            new Message($message),
            $type,
            \DateTimeImmutable::createFromFormat(self::DATE_TIME_FORMAT, $createdAt)
        );
    }
}