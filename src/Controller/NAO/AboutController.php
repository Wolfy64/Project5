<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AboutController extends AbstractController
{
    public function index() : Response
    {
        return $this->render('NAO/about.html.twig');
    }
}
