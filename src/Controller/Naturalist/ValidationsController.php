<?php

namespace App\Controller\Naturalist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Observation;


class ValidationsController extends AbstractController
{
    public function index(Request $request)
    {
        $observations = $this->getDoctrine()
            ->getRepository(Observation::class)
            ->findBy(['isValid' => false]);

        return $this->render('Naturalist/validations.html.twig',[
            'observations' => $observations
        ]);
    }

    public function isValid($id)
    {
        $observation = $this->getDoctrine()
            ->getRepository(Observation::class)
            ->find($id)
        ;

        if (!$observation){
            // flash message
            return $this->redirectToRoute('naturalist_validations');
        }

        $observation->setIsValid(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($observation);
        $em->flush();

        return $this->redirectToRoute('naturalist_validations');
    }
}
