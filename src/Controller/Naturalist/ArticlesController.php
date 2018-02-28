<?php

namespace App\Controller\Naturalist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\PostService;

class ArticlesController extends AbstractController
{
    public function index(PostService $post) : Response
    {
        return $this->render('Naturalist/articles.html.twig',[
            'posts' => $post->findAll()
        ]);
    }

    public function new(Request $request, PostService $post) : Response
    {
        $form = $post->postForm($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Votre article est mis en ligne');
            return $this->redirectToRoute('naturalist_articles');
        }

        return $this->render('Naturalist/newArticle.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function remove($id, PostService $post)
    {
        $postToRemove = $post->find($id);
        $message = PostService::NOT_FOUND;

        if ($postToRemove) {
            $post->doRemove($postToRemove);
            $message = 'L\'article à était supprimé';
        }

        $this->addFlash('notice', $message);

        return $this->redirectToRoute('naturalist_articles');
    }

    public function modify($id, PostService $post, Request $request)
    {
        $postToModify = $post->find($id);
        $message = PostService::NOT_FOUND;

        if ($postToModify) {
            $form = $post->modifyForm($postToModify, $request);

            if ($form->isSubmitted() && $form->isValid()) {
                $post->persist($postToModify);
                $this->addFlash('notice', 'L\'article à était modifié');

                return $this->redirectToRoute('naturalist_articles');
            }

            return $this->render('Naturalist/modifyArticle.html.twig', [
                'post' => $postToModify,
                'form' => $form->createView()
            ]);
        }

        $this->addFlash('notice', $message);

        return $this->redirectToRoute('naturalist_articles');
    }
}
