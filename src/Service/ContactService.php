<?php

namespace App\Service;

use Twig\Environment;

class ContactService
{
    const FLASH_MESSAGE = [
        1 => 'Votre message à été envoyé'
    ];

    private $mailer;
    private $message;

    public function __construct(Environment $twig, \Swift_Mailer $mailer) 
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->message;
    }

    public function getMessage() : string
    {
        return $this->message;
    }


    public function doMail($data)
    {
        $message = (new \Swift_Message('Nous avons bien reçu votre demande: "' . $data->getObject() . '"'))
            ->setFrom('contact@nao.dewulfdavid.com')
            ->setTo($data->getEmail())
            ->setBody($this->twig->render('Mail/contact.html.twig', ['data' => $data]), 'text/html')
        ;

        $this->message = self::FLASH_MESSAGE[1];
        $this->mailer->send($message);
    }
}
