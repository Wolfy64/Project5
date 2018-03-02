<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ObservationType;
use App\Service\ObservationService;
use App\Entity\Observation;

class ObserveController extends AbstractController
{
    public function index(Request $request, ObservationService $obsService) : Response
    {
        $observation = new Observation();

        $form = $this->createForm(ObservationType::class, $observation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['image']->getData();
            $obsService->handle($observation);
            
            if ($image) {
                $obsService->hasImage($image, $observation);
            }
            
            $obsService->isNaturalist($observation);
            $obsService->doValidation($observation);

            $this->addFlash('notice', $obsService->getMessage());

            return $this->redirectToRoute('observe');
        }

        return $this->render('NAO/observe.html.twig', [
            'form' => $form->createView()
        ]);
    }
}