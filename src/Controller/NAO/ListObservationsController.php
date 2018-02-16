<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Observation;

class ListObservationsController extends AbstractController
{
    public function index(Request $request) : Response
    {
        $observations = $this->getDoctrine()
            ->getRepository(Observation::class)
            ->findAll();

        if (!$observations) {
            throw $this->createNotFoundException(
                'No result'
            );
        }
        dump($observations);
        return $this->render('NAO/listObservations.html.twig', [
            'observations' => $observations
            ]);
    }
}