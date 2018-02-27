<?php

namespace App\Service;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Form;
use App\Entity\Contact;
use App\Form\ContactType;

class ContactService
{
    private $form;
    private $mailer;

    public function __construct(FormFactoryInterface $form)
    {
        $this->form = $form;
    }
    public function contactForm($request) : Form
    {
        $contact = new Contact();

        $form = $this->form->create(ContactType::class, $contact);
        $form->handleRequest($request);

        return $form;
    }
}