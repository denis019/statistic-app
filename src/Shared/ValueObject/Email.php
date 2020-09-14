<?php

declare(strict_types=1);

namespace SocialNetwork\Shared\ValueObject;

final class Email implements \Stringable
{

    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);

        $this->value = $value;
    }

    private function validate(string $value): bool
    {
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email is not valid');
        }
        return true;
    }

    public function __toString()
    {
        return $this->value;
    }
}