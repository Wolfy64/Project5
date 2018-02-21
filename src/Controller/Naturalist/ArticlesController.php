<?php

namespace App\Controller\Naturalist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticlesController extends AbstractController
{
    public function index() : Response
    {
        return $this->render('Naturalist/articles.html.twig');
    }
}
