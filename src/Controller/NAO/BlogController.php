<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\PostService;

class BlogController extends AbstractController
{
    public function index(PostService $post) : Response
    {
        return $this->render('NAO/blog.html.twig', [
            'posts' => $post->lastPublished(true, 3)
        ]);
    }
}