<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ObservationService;

class ObserveController extends AbstractController
{
    public function index(Request $request, ObservationService $observation) : Response
    {
        $form = $observation->observeForm($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Votre observation est en attente de validation par un de nos naturalistes');
            return $this->redirectToRoute('observe');
        }

        return $this->render('NAO/observe.html.twig', [
            'form' => $form->createView()
        ]);
    }
}