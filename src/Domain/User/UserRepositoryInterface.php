<?php

declare(strict_types=1);

namespace SocialNetwork\Domain\User;

interface UserRepositoryInterface
{
    public function findAll(): UserCollection;
}