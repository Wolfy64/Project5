<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Form;
use App\Entity\Newsletter;
use App\Form\NewsletterType;

class NewsletterService
{
    private $form;
    private $em;
    private $newsletter;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $form)
    {
        $this->form = $form;
        $this->em = $em;
        $this->newsletter = new Newsletter();
    }

    public function newsletterForm(Request $request) : Form
    {
        $form = $this->form->create(NewsletterType::class, $this->newsletter);
        $form->handleRequest($request);

        return $form;
    }

    public function isSubscribe(Form $form) : int
    {
        $email = $form->getData()->getEmail();
        return count($this->findByEmail($email));
    }

    public function findByEmail(string $email) : array
    {
        return $this->em->getRepository(Newsletter::class)->findBy([
            'email' => $email,
        ]);
    }

    public function persist() : void
    {
        // $user->setEmail();
        // dump($this->newsletter);
        // die;

        $this->em->persist($this->newsletter);
        $this->em->flush();
    }
}