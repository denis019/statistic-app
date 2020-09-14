<?php

declare(strict_types=1);

namespace SocialNetwork\Domain\User;

use SocialNetwork\Shared\Domain\Collection;

class UserCollection extends Collection
{

    protected function type(): string
    {
        return User::class;
    }
}