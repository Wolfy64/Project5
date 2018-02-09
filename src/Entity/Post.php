<?php

namespace App\Entity;

class Post
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $article;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getArticle(): string
    {
        return $this->article;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setArticle(string $article): void
    {
        $this->article = $article;
    }
}
