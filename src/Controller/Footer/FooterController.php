<?php

namespace App\Controller\Footer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Form;
use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Service\NewsletterService;

class FooterController extends AbstractController
{
    public function newsletter(Request $request, NewsletterService $newsletter, \Swift_Mailer $mailer) : Response
    {
        $form = $newsletter->newsletterForm($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            if ($newsletter->isSubscribe($form)) {
                $this->addFlash('notice', 'Cette email est déjà inscrit à la newsletter');
                return $this->redirectToRoute('about');
            }

            $newsletter->persist();
            $message = $this->message($form->getData());
            $mailer->send($message);

            $this->addFlash('notice', 'Vous etes inscrit à notre newsletter');

            return $this->redirectToRoute('about');
        }

        return $this->render('newsletter.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function message($data)
    {
        $message = (new \Swift_Message('Inscription à la newsletters'))
            ->setFrom('contact@nao.dewulfdavid.com')
            ->setTo($data->getEmail())
            ->setBody($this->renderView('Mail/newsletter.html.twig', ['data' => $data]), 'text/html');

        return $message;
    }
}