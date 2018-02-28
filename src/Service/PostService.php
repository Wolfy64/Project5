<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Form;
use App\Service\FileUploader;
use App\Entity\Post;
use App\Form\PostType;
use App\Form\Naturalist\ModifyPostType;

class PostService
{
    const NOT_FOUND = 'Cette article n\'existe pas';

    private $em;
    private $form;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $form, FileUploader $fileUploader)
    {
        $this->em = $em;
        $this->form = $form;
        $this->fileUploader = $fileUploader;
    }

    public function postForm($request) : Form
    {
        $post = new Post();

        $form = $this->form->create(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['image']->getData();

            $this->fileUploader->setTargetDir('img/blog');
            $fileName = $this->fileUploader->upload($file);
            $post->setImage($fileName);

            $this->persist($post);
        }

        return $form;
    }

    public function modifyForm(Post $post, $request) : Form
    {
        $form = $this->form->create(ModifyPostType::class, $post);
        $form->handleRequest($request);

        return $form;
    }

    public function find(int $id) : ? Post
    {
        return $this->em->getRepository(Post::class)->find($id);
    }

    public function findAll()
    {
        return $this->em->getRepository(Post::class)->findAll();
    }

    public function doRemove(Post $post) : void
    {
        $this->em->remove($post);
        $this->em->flush();
    }

    public function persist(Post $post) : void
    {
        $this->em->persist($post);
        $this->em->flush();
    }
}