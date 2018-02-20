<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MapType;
use App\Entity\Observation;

class MapController extends AbstractController
{
    public function index(Request $request, SessionInterface $session) : Response
    {
        $observation = new Observation();

        $form = $this->createForm(MapType::class, $observation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $commonName = $form->get('commonName')->getData();

            $observations = $this->getDoctrine()
                ->getRepository(Observation::class)
                ->findBy([
                    'commonName' => $commonName,
                    'isValid' => true,
                    ])
            ;

            if ($observations) {
                $session->set('observations', $observations);
                return $this->render('NAO/map.html.twig', [
                    'form' => $form->createView(),
                    'observations' => $observations
                ]);
            }
            
            $this->addFlash('notice', 'Nous n\'avons pas trouvé de resultats pour votre recherche');
        }

        return $this->render('NAO/map.html.twig',[
            'form' => $form->createView ()
        ]);
    }

    public function showList(SessionInterface $session)
    {
        return $this->render('NAO/mapShowList.html.twig',['observations' => $session->get('observations')]);
    }
}