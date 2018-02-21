<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\MapService;
use App\Form\MapType;
use App\Entity\Observation;

class MapController extends AbstractController
{
    public function index(Request $request, SessionInterface $session, MapService $map ) : Response
    {
        $form = $map->form($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $commonName = $form->get('commonName')->getData();
            $observations = $map->findBy($commonName);

            if (!$observations){
                $this->addFlash('notice', 'Nous n\'avons pas trouvé de resultats pour votre recherche');
                return $this->redirectToRoute('map');
            }

            return $this->render('NAO/map.html.twig', [
                'form' => $form->createView(),
                'observations' => $observations
            ]);
        }

        return $this->render('NAO/map.html.twig',[
            'form' => $form->createView ()
        ]);
    }

    public function showList(SessionInterface $session) : Response
    {
        return $this->render('NAO/mapShowList.html.twig',['observations' => $session->get('observations')]);
    }
}