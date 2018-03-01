<?php

namespace App\Controller\Naturalist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\Naturalist\ModifyObservationType;
use App\Service\ObservationService;
use App\Service\AvesService;

class ValidationsController extends AbstractController
{
    public function index(ObservationService $obsService) : Response
    {
        return $this->render('Naturalist/validations.html.twig',[
            'observations' => $obsService->isPublished(false)
        ]);
    }

    public function valid($id, ObservationService $obsService) : Response
    {
        $observation = $obsService->find($id);
        
        if ($observation) {
            $obsService->doValid($observation);
        }

        $this->addFlash('alert alert-warning alert-dismissible fade show', $obsService->getMessage());

        return $this->redirectToRoute('naturalist_validations');
    }

    public function remove($id, ObservationService $obsService) : Response
    {
        $observation = $obsService->find($id);

        if ($observation) {
            $obsService->doRemove($observation);
        }

        $this->addFlash('alert alert-warning alert-dismissible fade show', $obsService->getMessage());

        return $this->redirectToRoute('naturalist_validations');
    }

    public function modify($id, ObservationService $obsService, Request $request) : Response
    {
        $observation = $obsService->find($id);

        if ($observation){

            $form = $this->createForm(ModifyObservationType::class, $observation);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $obsService->doValid($observation);
                $this->addFlash('alert alert-warning alert-dismissible fade show', $obsService->getMessage());

                return $this->redirectToRoute('naturalist_validations');
            }

            return $this->render('Naturalist/modify_observation.html.twig', [
                'observation' => $observation,
                'form'        => $form->createView()
            ]);
        }

        $this->addFlash('alert alert-warning alert-dismissible fade show', $obsService->getMessage());

        return $this->redirectToRoute('naturalist_validations');
    }
}
