<?php

namespace App\Controller\Naturalist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Observation;


class ValidationsController extends AbstractController
{
    public function index()
    {
        $observations = $this->getDoctrine()
            ->getRepository(Observation::class)
            ->findBy(['isValid' => false]);
        return $this->render('Naturalist/validations.html.twig',['observations' => $observations]);
    }
}
