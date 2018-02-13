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
            $file = $form->getData();
            $file = $form['image']->getData();

            if ($file){
                $fileName = $fileUploader->upload($file);
                $observation->setImage($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($observation);
            $em->flush();
        }

        return $this->render('NAO/observe.html.twig', [
            'form' => $form->createView()
        ]);
    }
}