<?php

namespace App\Controller\Naturalist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Naturalist\ModifyPostType;
use App\Form\PostType;
use App\Service\PostService;
use App\Entity\Post;

class ArticlesController extends AbstractController
{
    public function index(PostService $post) : Response
    {
        return $this->render('Naturalist/articles.html.twig',[
            'posts' => $post->findAll()
        ]);
    }

    public function new(Request $request, PostService $postService) : Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form['image']->getData();
            $postService->doNew($image, $post);
            $this->addFlash('alert alert-warning alert-dismissible fade show', $postService->getMessage());

            return $this->redirectToRoute('naturalist_articles');
        }

        return $this->render('Naturalist/new_article.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function remove($id, PostService $postService)
    {
        $postToRemove = $postService->find($id);

        if ($postToRemove) {
            $postService->doRemove($postToRemove);
        }

        $this->addFlash('alert alert-warning alert-dismissible fade show', $postService->getMessage());

        return $this->redirectToRoute('naturalist_articles');
    }

    public function modify($id, PostService $postService, Request $request)
    {
        $post = $postService->find($id);

        if ($post) {

            $form = $this->createForm(ModifyPostType::class, $post);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $postService->doModify($post);
                $this->addFlash('alert alert-warning alert-dismissible fade show', $postService->getMessage());
                
                return $this->redirectToRoute('naturalist_articles');
            }

            return $this->render('Naturalist/modify_article.html.twig', [
                'post' => $post,
                'form' => $form->createView()
            ]);
        }

        $this->addFlash('alert alert-warning alert-dismissible fade show', $postService->getMessage());

        return $this->redirectToRoute('naturalist_articles');
    }
}