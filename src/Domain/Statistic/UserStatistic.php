<?php

declare(strict_types=1);

namespace SocialNetwork\Domain\Statistic;

use SocialNetwork\Domain\Post\Post;
use SocialNetwork\Domain\User\User;

class UserStatistic
{
    private User $user;
    private DateTimePostStatistic $periodPostStatistic;

    public function __construct(User $user, DateTimePostStatistic $periodPostStatistic)
    {
        $this->user = $user;
        $this->periodPostStatistic = $periodPostStatistic;
    }

    public function addPost(Post $post): void
    {
        $this->periodPostStatistic->addPost($post);
    }

    public function getPeriodPostStatistic(): DateTimePostStatistic
    {
        return $this->periodPostStatistic;
    }
}