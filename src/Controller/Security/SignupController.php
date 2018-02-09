<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Entity\User;

class SignupController extends AbstractController
{
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'action' => '/inscription'
        ]);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(User::ROLE_USER);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('home_page');
        }

        return $this->render('Security/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}