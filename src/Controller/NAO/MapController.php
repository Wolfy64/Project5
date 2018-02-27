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
        
        if ($form->isSubmitted() && $form->isValid()) {
            $observations = $observation->findByCommonName($form->get('commonName')->getData());
            // $session->set('observations', $observations);
            
            if (!$observations){
                $this->addFlash('notice', 'Aucun résultat pour la recherche: ' . $form['commonName']->getData());
            }

            return $this->render('NAO/map.html.twig', [
                'observations' => $observations,
                'form' => $form->createView()
            ]);
        }

        return $this->render('NAO/map.html.twig',['form'=> $form->createView ()]);
    }

    public function showList(ObservationService $observation, SessionInterface $session, $commonName) : Response
    {
        $observations = $observation->findByCommonName($commonName);

        return $this->render('NAO/mapShowList.html.twig',[
            // 'observations' => $session->get('observations'),
            'observations' => $observations,
            'birdInfos'    => $observation->birdInfos($session->get('observations'))
        ]);
    }
}