<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MapType;
use App\Entity\Observation;

class MapController extends AbstractController
{
    public function index(Request $request) : Response
    {
        $observation = new Observation();

        $form = $this->createForm(MapType::class, $observation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->get('commonName')->getData();

            $observation = $this->getDoctrine()
                ->getRepository(Observation::class)
                ->findBy(['commonName' => $data]
            );

            if ($observation) {
                return $this->render('NAO/map.html.twig', [
                    'form' => $form->createView(),
                    'observation' => $observation
                ]);
            }
            
            $this->addFlash('notice', 'Nous n\'avons pas trouvé de resultats pour votre recherche');
        }

        return $this->render('NAO/map.html.twig',[
            'form' => $form->createView ()
        ]);
    }

    public function showList()
    {
        return $this->render('NAO/mapShowList.html.twig');
    }
}