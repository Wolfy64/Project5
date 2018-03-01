<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ObservationService;

class MyObservationsController extends AbstractController
{
    public function index(ObservationService $obsService) : Response
    {
        return $this->render('NAO/my_observations.html.twig',[
            'obsNotValid' => $obsService->findByUser(false),
            'obsValid'    => $obsService->findByUser(true)
        ]);
    }
}
