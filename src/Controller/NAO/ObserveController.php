<?php

namespace App\Controller\NAO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Observation;
use App\Form\ObservationType;
use App\Service\FileUploader;

class ObserveController extends AbstractController
{
    public function index(Request $request, FileUploader $fileUploader) : Response
    {
        $observation = new Observation();
        $form = $this->createForm(ObservationType::class, $observation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $observation = $form->getData();
            $observation->setIsValid(false);
            $file = $form['image']->getData();
           
            if ($file){
                $fileName = $fileUploader->upload($file);
                $observation->setImage($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($observation);
            $em->flush();

            $this->addFlash('notice','Votre observation est en attente de validation par un de nos naturalistes');
        }

        return $this->render('NAO/observe.html.twig', [
            'form' => $form->createView()
        ]);
    }
}