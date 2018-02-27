<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\UserService;

class SignupController extends AbstractController
{
    public function index(Request $request, UserService $user, \Swift_Mailer $mailer) : Response
    {
        $form = $user->form($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($user->isTaken($form)){
                $this->addFlash('notice', 'Cette email est deja utilisé veuillez saisir une nouvelle adresse email');
                return $this->redirectToRoute('security_signup');
            }
            
            $user->persist();
            $message = $this->message($form->getData());
            $mailer->send($message);
            $this->addFlash('notice', 'Vous etes inscrit, un email vous a été envoyé');

            return $this->redirectToRoute('about');
        }

        return $this->render('Security/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function message($data)
    {
        $message = (new \Swift_Message('Bienvenu à Nos Amis les Oiseaux !'))
            ->setFrom('contact@nao.dewulfdavid.com')
            ->setTo($data->getUsername())
            ->setBody($this->renderView('Mail/signup.html.twig', ['data' => $data]), 'text/html');

        return $message;
    }
}