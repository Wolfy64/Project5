<?php

namespace App\Service;

use Symfony\Component\Form\FormFactoryInterface;
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
    }

    public function form($request)
    {
        $user = new User();

        $form = $this->form->create(UserType::class, $user, ['action' => '/inscription']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);
            $user->setIsActive(true);
            $user->setRoles(User::ROLE_USER);

            $this->em->persist($user);
            $this->em->flush();
        }

        return $form;
    }

}