<?php

namespace App\Service;

// use Symfony\Component\Form\FormFactoryInterface;
// use Symfony\Component\Form\Form;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use App\Entity\User;
use App\Form\UserType;

class UserService
{
    const FLASH_MESSAGE = [
        1 => 'Cette email est déjà utilisé veuillez saisir une nouvelle adresse email',
        2 => 'Vous etes inscrit, un email vous a été envoyé'
    ];

    private $em;
    private $mailer;
    private $passwordEncoder;
    private $message;

    public function __construct(
        EntityManagerInterface $em, 
        UserPasswordEncoderInterface $passwordEncoder,
        Environment $twig,
        \Swift_Mailer $mailer)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->message;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function isTaken(string $username) : int
    {
        $result = count($this->findBy($username));

        if ($result) {
            $this->message = self::FLASH_MESSAGE[1];
        }

        return $result;
    }

    public function findBy(string $username) : array
    {
        return $this->em->getRepository(User::class)->findBy(['username' => $username,]);
    }

    public function handle(User $user) : void
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());

        $user->setPassword($password);
        $user->setIsActive(true);
        $user->setRoles(User::ROLE_USER);

        $this->persist($user);
    }

    public function doMail($data)
    {
        $message = (new \Swift_Message('Bienvenu à Nos Amis les Oiseaux !'))
            ->setFrom('contact@nao.dewulfdavid.com')
            ->setTo($data->getUsername())
            ->setBody($this->twig->render('Mail/signup.html.twig', ['data' => $data]), 'text/html')
        ;

        $this->message = self::FLASH_MESSAGE[2];
        $this->mailer->send($message);
    }

    public function persist(User $user) : void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}