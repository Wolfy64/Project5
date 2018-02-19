<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Entity\User;

class SignupController extends AbstractController
{
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user, ['action' => '/inscription']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            
            $user->setPassword($password);
            $user->setIsActive(true);
            $user->setRoles(User::ROLE_USER);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('Security/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}