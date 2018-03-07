<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use App\Entity\Newsletter;

class NewsletterService
{
    const FLASH_MESSAGE = [
        1 => 'Cette adresse email est déjà inscrite à la newsletter',
        2 => 'Vous ètes inscrit à notre newsletter'
    ];

    private $em;
    private $twig;
    private $mailer;
    private $message;

    public function __construct(EntityManagerInterface $em, Environment $twig, \Swift_Mailer $mailer)
    {
        $this->em = $em;
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function getMesasge() : string
    {
        return $this->message;
    }

    public function isSubscribe(string $email) : int
    {
        $result = count($this->findByEmail($email));

        if ($result){
            $this->message = self::FLASH_MESSAGE[1];
        }

        return $result;
    }

    public function findByEmail(string $email) : array
    {
        return $this->em->getRepository(Newsletter::class)->findBy(['email' => $email]);
    }

    public function persist($newsletter) : void
    {
        $this->em->persist($newsletter);
        $this->em->flush();
    }

    public function doMail($data)
    {
        $message = (new \Swift_Message('Inscription à la newsletters'))
            ->setFrom('contact@nao.dewulfdavid.com')
            ->setTo($data->getEmail())
            ->setBody($this->twig->render('Mail/newsletter.html.twig', ['data' => $data]), 'text/html');

        $this->message = self::FLASH_MESSAGE[2];
        $this->mailer->send($message);
    }
}