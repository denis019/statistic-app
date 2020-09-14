<?php

declare(strict_types=1);

namespace SocialNetwork\Domain\Statistic;

use SocialNetwork\Domain\Post\Post;

class DateTimePostStatistic
{

    /** @var DateTimePost[] */
    private array $dateTimePosts = [];

    private string $dateTimeFormat;

    public function __construct(string $dateTimeFormat)
    {
        $this->dateTimeFormat = $dateTimeFormat;
    }

    public function addPost(Post $post)
    {
        $dateFormatted = $post->getCreatedAt()->format($this->dateTimeFormat);

        $dateTimePost = $this->dateTimePosts[$dateFormatted] ?? new DateTimePost($dateFormatted);
        $dateTimePost->addPost($post);
        $this->dateTimePosts[$dateFormatted] = $dateTimePost;
    }

    /**
     * @return DateTimePost[]
     */
    public function getDateTimePosts(): array
    {
        return $this->dateTimePosts;
    }
}