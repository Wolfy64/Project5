<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class JoinUsController extends AbstractController
{
    public function index() : Response
    {
        return $this->render('NAO/join_us.html.twig');
    }

    public function showFiles() : BinaryFileResponse
    {
        return new BinaryFileResponse('files/formulaire_adhesion.pdf');
    }
}