<?php

namespace App\Service;

use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Observation;
use App\Form\ObservationType;
use App\Service\FileUploader;

class ObservationService
{
    private $em;
    private $form;
    private $fileUploader;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $form, FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
        $this->form = $form;
        $this->em = $em;
    }

    public function form($request)
    {
        $observation = new Observation();

        $form = $this->form->create(ObservationType::class, $observation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $observation->setIsValid(false);
            $observation->setImage('no_image.png');

            $file = $form['image']->getData();

            if ($file){
                $fileName = $this->fileUploader->upload($file);
                $observation->setImage($fileName);
            }

            $this->em->persist($observation);
            $this->em->flush();
        }

        return $form;
    }

    public function showList()
    {
        return $this->em->getRepository(Observation::class)->findBy(['isValid' => true]);
    }

    public function showListNotValid()
    {
        return $this->em->getRepository(Observation::class)->findBy(['isValid' => false]);
    }

    public function isValid($id)
    {
        $observation = $this->em->getRepository(Observation::class)->find($id);

        if (!$observation){
            return false;
        }

        $observation->setIsValid(true);

        $this->em->persist($observation);
        $this->em->flush();

        return true;
    }
}