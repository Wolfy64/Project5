<?php

namespace App\Controller\Naturalist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ObservationService;
use App\Service\AvesService;
use App\Entity\Observation;

class ValidationsController extends AbstractController
{
    public function index(ObservationService $observation) : Response
    {
        return $this->render('Naturalist/validations.html.twig',[
            'observations' => $observation->isPublished(false)
        ]);
    }

    public function isValid($id, ObservationService $observation, AvesService $aves) : Response
    {
        $obsToValid = $observation->find($id);//
        $message = ObservationService::NOT_FOUND;

        if ($obsToValid) {
            $message = 'Attention le nom de l\'oiseau doit correspondre à la base de donnée Aves';

            $addAves = $aves->addAves($obsToValid);

            if (count($addAves->getAveses())) {
                $message = 'L\'observation à était validé';
                $observation->doValid($obsToValid);
            }
        }

        $this->addFlash('notice', $message);
        // ### TEST ###
        // $obsRepo = $this->getDoctrine()->getRepository(Observation::class)->find($obsToValid->getId());
        // $obsRepo = $this->getDoctrine()->getRepository(Observation::class)->find(6);
        // dump($obsToValid);
        // die; 
        // ### END TEST ###
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
                $observation->persist($obsToModify);
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
