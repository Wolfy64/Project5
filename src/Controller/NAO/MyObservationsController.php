<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ObservationService;

class MyObservationsController extends AbstractController
{
    public function index(ObservationService $observation) : Response
    {
        $obsValid = $observation->findByUser(true);
        $obsNotValid = $observation->findByUser(false);

        return $this->render('NAO/myObservations.html.twig',[
            'obsValid' => $obsValid,
            'obsNotValid' => $obsNotValid,
        ]);
    }
}
