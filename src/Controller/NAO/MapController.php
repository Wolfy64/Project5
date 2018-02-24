<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ObservationService;
use App\Entity\Observation;

class MapController extends AbstractController
{
    public function index(Request $request, SessionInterface $session, ObservationService $observation ) : Response
    {
        // ### TEST ###

        // $id = 6;
        // $obsRepo = $this->getDoctrine()->getRepository(Observation::class)->find($id);
        // dump($obsRepo);

        // die;
        // ### END TEST ###
        $form = $observation->mapForm($request);

        $observations = $observation->findByCommonName($form->get('commonName')->getData());
        // $testId = $observations[0]->getId();
        $obsRepo = $this->getDoctrine()->getRepository(Observation::class)->find($observations[0]->getId());
        dump($obsRepo->getAveses());
        if ($form->isSubmitted() && $form->isValid()) {
            $session->set('observations', $observations);

            if (!$observations){
                $this->addFlash('notice', 'Aucun résultat pour la recherche: ' . $form['commonName']->getData());
            }
        }

        return $this->render('NAO/map.html.twig',[
            'observations' => $observations,
            'form'         => $form->createView ()
        ]);
    }

    public function showList(SessionInterface $session) : Response
    {
        return $this->render('NAO/mapShowList.html.twig',['observations' => $session->get('observations')]);
    }
}