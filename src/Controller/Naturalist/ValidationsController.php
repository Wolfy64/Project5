<?php

namespace App\Controller\Naturalist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ObservationService;

class ValidationsController extends AbstractController
{
    public function index(Request $request, ObservationService $observation) : Response
    {
        $observations = $observation->showListNotValid();

        return $this->render('Naturalist/validations.html.twig',[
            'observations' => $observations
        ]);
    }

    public function isValid($id, ObservationService $observation) : Response
    {
        $isValid = $observation->isValid($id);

        if (!$isValid){
            $this->addFlash('notice', 'Cette observation n\'existe pas');
            return $this->redirectToRoute('naturalist_validations');
        }

        $this->addFlash('notice', 'L\'observation à était validé');

        return $this->redirectToRoute('naturalist_validations');
    }

    public function delete($id, ObservationService $observation) : Response
    {
        $delete = $observation->delete($id);

        if (!$delete) {
            $this->addFlash('notice', 'Cette observation n\'existe pas');
            return $this->redirectToRoute('naturalist_validations');
        }

        $this->addFlash('notice', 'L\'observation à était supprimé');

        return $this->redirectToRoute('naturalist_validations');
    }
}
