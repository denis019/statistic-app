<?php

declare(strict_types=1);

namespace SocialNetwork\Infrastructure\Repository;

use SocialNetwork\Domain\Post\PostFactory;
use SocialNetwork\Domain\User\UserCollection;
use SocialNetwork\Domain\User\UserFactory;
use SocialNetwork\Domain\User\UserRepositoryInterface;
use SocialNetwork\Infrastructure\SlToken\SlTokenInterface;
use SocialNetwork\Shared\ValueObject\Url;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class HttpUserRepository implements UserRepositoryInterface
{
    private Url $url;
    private int $totalPages;
    private SlTokenInterface $slToken;
    private HttpClientInterface $client;

    public function __construct(
        Url $url,
        int $totalPages,
        SlTokenInterface $slToken,
        HttpClientInterface $client
    )
    {
        $this->url = $url;
        $this->totalPages = $totalPages;
        $this->slToken = $slToken;
        $this->client = $client;
    }

    public function findAll(): UserCollection
    {
        $users = [];
        $slToken = $this->slToken->get();

        $url = (string)$this->url . '?sl_token=' . $slToken;

        $responses = [];
        for ($i = 0; $i < $this->totalPages; ++$i) {
            $page = $i + 1;
            $responses[] = $this->client->request('GET', $url . '&page=' . $page);
        }

        foreach ($this->client->stream($responses) as $response => $chunk) {
            if ($chunk->isLast()) {
                // the full content of $response just completed
                // $response->getContent() is now a non-blocking call
                $this->addUsersFromResponseData($response->toArray(), $users);
            }
        }

        return new UserCollection($users);
    }

    private function addUsersFromResponseData(array $response, array &$users): void
    {
        foreach ($response['data']['posts'] as $userPost) {
            $userId = $userPost['from_id'];

            $post = PostFactory::create(
                $userPost['id'],
                $userPost['message'],
                $userPost['type'],
                $userPost['created_time']
            );

            $user = $users[$userId] ?? UserFactory::create($userId, $userPost['from_name']);
            $user->addPost($post);
            $users[$userId] = $user;
        }
    }
}