<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ObservationService;

class ListObservationsController extends AbstractController
{
    public function index(Request $request, ObservationService $observation) : Response
    {
        return $this->render('NAO/listObservations.html.twig', [
            'observations' => $observation->isPublished(true)
        ]);
    }
}