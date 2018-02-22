<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\UserService;

class SignupController extends AbstractController
{
    public function index(Request $request, UserService $user) : Response
    {
        $form = $user->form($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('security_login');
        }

        return $this->render('Security/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}