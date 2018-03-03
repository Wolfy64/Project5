<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MentionsLegalesController extends AbstractController
{
    public function index() : Response
    {
        return $this->render('NAO/MentionsLegales.html.twig');
    }
}