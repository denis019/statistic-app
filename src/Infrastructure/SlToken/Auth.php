<?php

declare(strict_types=1);

namespace SocialNetwork\Infrastructure\SlToken;

use SocialNetwork\Shared\ValueObject\Email;
use SocialNetwork\Shared\ValueObject\Url;

class Auth
{

    private Url $url;
    private string $clientId;
    private Email $email;
    private string $name;

    public function __construct(
        Url $url,
        string $clientId,
        Email $email,
        string $name
    )
    {
        $this->url = $url;
        $this->clientId = $clientId;
        $this->email = $email;
        $this->name = $name;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }
}