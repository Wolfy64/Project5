<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class JoinUsController extends AbstractController
{
    public function index() : Response
    {
        return $this->render('NAO/joinUs.html.twig');
    }
}