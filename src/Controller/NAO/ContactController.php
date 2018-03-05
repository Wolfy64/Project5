<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;
use App\Entity\Contact;
use App\Service\ContactService;

class ContactController extends AbstractController
{
    public function index(Request $request, ContactService $contactService) : Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactService->doMail($form->getData());
            $this->addFlash('notice', $contactService->getMessage());

            return $this->redirectToRoute('contact');
        }

        return $this->render('NAO/contact.html.twig',[
            'form' => $form->createView()
        ]);
    }
}