<?php

declare(strict_types=1);

namespace SocialNetwork\Domain\Statistic;

use SocialNetwork\Domain\Post\Post;

class DateTimePost
{
    private string $format;
    private int $totalPosts = 0;
    private int $totalLength = 0;
    private Post $longestPost;

    /**
     * @param string $format
     * @link https://www.php.net/manual/en/datetime.format.php
     */
    public function __construct(string $format)
    {
        $this->format = $format;
    }

    public function addPost(Post $post): void
    {
        $this->totalPosts++;
        $this->totalLength += $post->getMessage()->getLength();

        if (!isset($this->longestPost)) {
            $this->longestPost = $post;
            return;
        }

        if ($post->getMessage()->getLength() > $this->longestPost->getMessage()->getLength()) {
            $this->longestPost = $post;
        }
    }

    public function getTotalPosts(): int
    {
        return $this->totalPosts;
    }

    public function getTotalLength(): int
    {
        return $this->totalLength;
    }

    public function getAverageCharacterLengthOfPosts(): float
    {
        if ($this->totalLength > 0 && $this->totalPosts > 0) {
            return $this->totalLength / $this->totalPosts;
        }

        return 0;
    }

    public function getLongestPost(): Post
    {
        return $this->longestPost;
    }
}