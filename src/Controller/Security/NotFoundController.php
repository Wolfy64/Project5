<?php
/**
 * Created by PhpStorm.
 * User: gueno
 * Date: 28/02/2018
 * Time: 16:03
 */

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NotFoundController extends AbstractController
{
    public function index() : Response
    {
        return $this->render('Security/404.html.twig');
    }
}