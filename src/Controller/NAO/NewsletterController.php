<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Service\NewsletterService;

class NewsletterController extends AbstractController
{
    public function index(Request $request, NewsletterService $newsLetterService) : Response
    {
        $newsletter = new Newsletter();

        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $email = $form->getData()->getEmail();
            $isSubscribe = $newsLetterService->isSubscribe($email);

            if ($isSubscribe) {
                $this->addFlash('alert alert-warning alert-dismissible fade show', $newsLetterService->getMesasge());

                return $this->redirectToRoute('about');
            }

            $newsLetterService->persist($newsletter);
            $newsLetterService->doMail($newsletter);
            $this->addFlash('notice', $newsLetterService->getMesasge());

            return $this->redirectToRoute('about');
        }

        return $this->render('newsletter.html.twig', ['form' => $form->createView()]);
    }
}