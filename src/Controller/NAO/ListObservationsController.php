<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ObservationService;

class ListObservationsController extends AbstractController
{
    public function index(ObservationService $observation) : Response
    {
        return $this->render('NAO/list_observations.html.twig', [
            'observations' => $observation->lastPublished(true, 15)
        ]);
    }
}