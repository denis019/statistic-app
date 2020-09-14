<?php

declare(strict_types=1);

namespace SocialNetwork\Infrastructure\SlToken;

interface SlTokenInterface
{
    public function get(): string;
}