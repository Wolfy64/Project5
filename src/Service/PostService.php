<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\FileUploader;
use App\Entity\Post;

class PostService
{
    const NOT_FOUND = 'Cette article n\'existe pas';
    const FLASH_MESSAGE = [
        1 => 'Votre article est mis en ligne',
        2 => 'L\'article à était supprimé',
        3 => 'L\'article à était modifié'
    ];

    private $em;
    private $message;

    public function __construct(EntityManagerInterface $em, FileUploader $fileUploader)
    {
        $this->em = $em;
        $this->fileUploader = $fileUploader;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function doNew($image, Post $post) : void
    {
        $this->fileUploader->setTargetDir('img/blog');
        $imageName = $this->fileUploader->upload($image);
        $post->setPublished(true);
        $post->setImage($imageName);
        $this->persist($post);
        $this->message = self::FLASH_MESSAGE[1];
    }

    public function doRemove(Post $post) : void
    {
        $this->message = self::FLASH_MESSAGE[2];
        $this->em->remove($post);
        $this->em->flush();
    }

    public function doModify(Post $post) : void
    {
        $this->message = self::FLASH_MESSAGE[3];
        $this->persist($post);
    }

    public function find(int $id) : ? Post
    {
        $result = $this->em->getRepository(Post::class)->find($id);

        if (!$result) {
            $this->message = self::NOT_FOUND;
        }

        return $result;
    }

    public function lastPublished(bool $bool, int $limit) : array
    {
        return $this->em->getRepository(Post::class)->findBy(
            ['published' => $bool],
            ['id' => 'DESC'],
            $limit
        );
    }

    public function findAll()
    {
        return $this->em->getRepository(Post::class)->findAll();
    }

    public function persist(Post $post) : void
    {
        $this->em->persist($post);
        $this->em->flush();
    }
}