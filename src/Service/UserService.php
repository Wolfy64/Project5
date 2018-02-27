<?php

namespace App\Service;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\UserType;

class UserService
{
    private $em;
    private $form;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $form, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->form = $form;
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->user = new User();
    }

    public function form($request) : Form
    {
        $user = $this->user;
        $form = $this->form->create(UserType::class, $user, ['action' => '/inscription']);
        $form->handleRequest($request);

        return $form;
    }

    public function isTaken($form)
    {
        $username = $form->getData()->getUsername();
        return count($this->findBy($username));
    }

    public function findBy($username)
    {
        return $this->em->getRepository(User::class)->findBy([
            'username' => $username,
        ]);
    }

    public function persist()
    {
        $user = $this->user;
        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());

        $user->setPassword($password);
        $user->setIsActive(true);
        $user->setRoles(User::ROLE_USER);

        $this->em->persist($user);
        $this->em->flush();
    }
}