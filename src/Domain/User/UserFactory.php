<?php

declare(strict_types=1);

namespace SocialNetwork\Domain\User;

class UserFactory
{
    public static function create(string $id, string $name): User
    {
        return new User($id, $name);
    }
}