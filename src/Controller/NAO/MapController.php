<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Observation;

class MapController extends AbstractController
{
    public function index() : Response
    {
        $observations = $this->getDoctrine()
            ->getRepository(Observation::class)
            ->findAll();

        if (!$observations) {
            throw $this->createNotFoundException(
                'No result'
            );
        }

        return $this->render('NAO/map.html.twig');
    }
}