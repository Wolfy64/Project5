<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\UserService;
use App\Entity\User;
use App\Form\UserType;

class SignupController extends AbstractController
{
    public function index(Request $request, UserService $userService) : Response
    {
        $user = new user();

        $form = $this->createForm(UserType::class, $user, ['action' => '/inscription']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->getData()->getUsername();

            if($userService->isTaken($username)){
                $this->addFlash('notice', $userService->getMessage());

                return $this->redirectToRoute('security_signup');
            }

            $userService->handle($user);
            $userService->doMail($form->getData());
            $this->addFlash('notice', $userService->getMessage());

            return $this->redirectToRoute('about');
        }

        return $this->render('Security/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}