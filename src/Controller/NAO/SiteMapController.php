<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteMapController extends AbstractController
{
    public function index() : Response
    {
        return $this->render('NAO/site_map.html.twig');
    }
}