<?php

declare(strict_types=1);

namespace SocialNetwork\Infrastructure\SlToken;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SlToken implements SlTokenInterface
{
    private HttpClientInterface $httpClient;
    private Auth $auth;
    private string $token;

    public function __construct(Auth $auth, HttpClientInterface $httpClient)
    {
        $this->auth = $auth;
        $this->httpClient = $httpClient;
    }

    public function get(): string
    {
        if (isset($this->token)) {
            return $this->token;
        }

        $response = $this->httpClient->request('POST', (string)$this->auth->getUrl(), [
            'json' => [
                'client_id' => $this->auth->getClientId(),
                'email' => (string)$this->auth->getEmail(),
                'name' => $this->auth->getName(),
            ],
        ]);

        $decodedPayload = $response->toArray();

        $this->token = $decodedPayload['data']['sl_token'] ?? '';

        return $this->token;
    }
}