<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class LegalNoticesController extends AbstractController
{
    public function index() : Response
    {
        return $this->render('NAO/legal_notices.html.twig');
    }
}