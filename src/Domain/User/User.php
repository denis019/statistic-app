<?php

declare(strict_types=1);

namespace SocialNetwork\Domain\User;

use SocialNetwork\Domain\Post\Post;
use SocialNetwork\Domain\Post\PostCollection;

class User
{
    private string $id;
    private string $name;
    private PostCollection $posts;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPosts(): PostCollection
    {
        return $this->posts;
    }

    public function setPosts(PostCollection $posts): void
    {
        $this->posts = $posts;
    }

    public function addPost(Post $post): PostCollection
    {
        if (isset($this->posts)) {
            $this->getPosts()->addItem($post);
        } else {
            $this->setPosts(new PostCollection([$post]));
        }


        return $this->posts;
    }
}