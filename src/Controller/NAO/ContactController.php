<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;
use App\Entity\Contact;

class ContactController extends AbstractController
{
    public function index(Request $request, \Swift_Mailer $mailer) : Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $message = $this->message($form->getData());
            $mailer->send($message);
            $this->addFlash('alert alert-warning alert-dismissible fade show', 'Votre message à été envoyé');

            return $this->redirectToRoute('contact');
        }

        return $this->render('NAO/contact.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function message($data)
    {
        $message = (new \Swift_Message('Nous avons bien reçu votre demande: "' . $data->getObject() . '"'))
            ->setFrom('contact@nao.dewulfdavid.com')
            ->setTo($data->getEmail())
            ->setBody($this->renderView('Mail/contact.html.twig',['data' => $data]),'text/html')
        ;

        return $message;
    }
}