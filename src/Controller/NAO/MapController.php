<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ObservationService;

class MapController extends AbstractController
{
    public function index(Request $request, SessionInterface $session, ObservationService $observation ) : Response
    {
        $form = $observation->mapForm($request);

        $observations = $observation->findByCommonName($form->get('commonName')->getData());

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