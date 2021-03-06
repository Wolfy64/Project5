<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ObservationService;
use App\Entity\Observation;
use App\Form\MapType;

class MapController extends AbstractController
{
    public function index(Request $request, SessionInterface $session, ObservationService $obsService ) : Response
    {
        $observation = new Observation();

        $form = $this->createForm(MapType::class, $observation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $commonName = $form->get('commonName')->getData();
            $department = $obsService->doIntDpt($form->get('department')->getData());

            $observations = $obsService->findBirds($commonName, $department);
            $mapInfos = $obsService->mapInfos($observations);

            if (!$observations){
                $this->addFlash('notice', $obsService->getMessage());
                return $this->redirectToRoute('map');
            }

            $session->set('observations', ($observations));
            $session->set('birdInfos', $obsService->birdInfos($observations));

            return $this->render('NAO/map.html.twig', [
                'observations' => $observations,
                'mapInfos'     => $mapInfos,
                'form'         => $form->createView()
            ]);
        }

        return $this->render('NAO/map.html.twig',['form'=> $form->createView ()]);
    }

    public function showList(SessionInterface $session) : Response
    {
        return $this->render('NAO/map_show_list.html.twig',[
            'observations' => $session->get('observations'),
            'birdInfos'    => $session->get('birdInfos')
        ]);
    }
}