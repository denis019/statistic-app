<?php

declare(strict_types=1);

namespace SocialNetwork\Domain\Post;

use SocialNetwork\Shared\Domain\Collection;

class PostCollection extends Collection
{

    protected function type(): string
    {
        return Post::class;
    }
}