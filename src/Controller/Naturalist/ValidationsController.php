<?php

namespace App\Controller\Naturalist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ObservationService;

class ValidationsController extends AbstractController
{
    public function index(ObservationService $observation) : Response
    {
        return $this->render('Naturalist/validations.html.twig',[
            'observations' => $observation->isPublished(false)
        ]);
    }

    public function isValid($id, ObservationService $observation) : Response
    {
        $obsToValid = $observation->find($id);
        $message = ObservationService::NOT_FOUND;

        if ($obsToValid){
            $observation->doValid($obsToValid);
            $message = 'L\'observation à était validé';
        }
        
        $this->addFlash('notice', $message);
        
        return $this->redirectToRoute('naturalist_validations');
    }

    public function remove($id, ObservationService $observation) : Response
    {
        $obsToRemove = $observation->find($id);
        $message = ObservationService::NOT_FOUND;

        if ($obsToRemove) {
            $observation->doRemove($obsToRemove);
            $message = 'L\'observation à était supprimé';
        }

        $this->addFlash('notice', $message);

        return $this->redirectToRoute('naturalist_validations');
    }

    public function modify($id, ObservationService $observation, Request $request) : Response
    {
        $obsToModify = $observation->find($id);
        $message = ObservationService::NOT_FOUND;

        if ($obsToModify){
            $form = $observation->modifyForm($obsToModify, $request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->addFlash('notice', 'L\'observation à était modifié et validé');

                return $this->redirectToRoute('naturalist_validations');
            }

            return $this->render('Naturalist/modifyObservation.html.twig', [
                'observation' => $obsToModify,
                'form' => $form->createView()
            ]);
        }

        $this->addFlash('notice', $message);

        return $this->redirectToRoute('naturalist_validations');
    }
}
