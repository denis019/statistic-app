<?php

declare(strict_types=1);

namespace SocialNetwork\Shared\ValueObject;

final class Url implements \Stringable
{

    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);

        $this->value = $value;
    }

    private function validate(string $value): bool
    {
        if (false === filter_var($value, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('URL is not valid');
        }
        return true;
    }

    public function __toString()
    {
        return $this->value;
    }
}