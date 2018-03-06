<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Post
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $article;

    /**
     * @var string
     */
    private $author;

    /**
     * @var date
     */
    private $date;

    /**
     * @var bool
     */
    private $published;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getImage() : ? string
    {
        return $this->image;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImage($image) : void
    {
        $this->image = $image;
    }

    public function getTitle() : ? string
    {
        return $this->title;
    }

    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function getArticle() : ? string
    {
        return $this->article;
    }

    public function setArticle(string $article) : void
    {
        $this->article = $article;
    }

    public function getAuthor() : ? string
    {
        return $this->author;
    }

    public function setAuthor(string $author) : void
    {
        $this->author = $author;
    }

    public function getDate() : ? \DateTime
    {
        return $this->date;
    }

    public function getPublished() : ? bool
    {
        return $this->published;
    }

    public function setPublished(bool $published) : void
    {
        $this->published = $published;
    }
}
