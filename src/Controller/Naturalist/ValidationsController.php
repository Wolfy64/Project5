<?php

namespace App\Controller\Naturalist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ValidationsController extends AbstractController
{
    public function index()
    {
        return $this->render('Naturalist/validations.html.twig');
    }
}
