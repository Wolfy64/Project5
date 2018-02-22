<?php

namespace App\Service;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Form;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Naturalist\ModifyObservationType;
use App\Form\MapType;
use App\Form\ObservationType;
use App\Service\FileUploader;
use App\Entity\Observation;

class ObservationService
{
    const NOT_FOUND = 'Cette observation n\'existe pas';

    private $em;
    private $form;
    private $fileUploader;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $form, FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
        $this->form = $form;
        $this->em = $em;
    }

    public function ObserveForm($request) : Form
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

            $this->persist($observation);
        }

        return $form;
    }

    public function mapForm($request) : Form
    {
        $observation = new Observation();

        $form = $this->form->create(MapType::class, $observation);
        $form->handleRequest($request);

        return $form;
    }

    public function modifyForm($observation, $request) : Form
    {
        $form = $this->form->create(ModifyObservationType::class, $observation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $observation->setIsValid(true);
            $this->persist($observation);
        }

        return $form;
    }

    public function find($id) :?  Observation
    {
        return $this->em->getRepository(Observation::class)->find($id);
    }

    public function findByCommonName($commonName) : array
    {
        return $this->em->getRepository(Observation::class)->findBy([
            'commonName' => $commonName,
            'isValid' => true,
        ]);
    }

    public function isPublished($bool) : array
    {
        return $this->em->getRepository(Observation::class)->findBy(['isValid' => $bool]);
    }

    public function doValid($observation) : void
    {
        $observation->setIsValid(true);
        $this->persist($observation);
    }

    public function doRemove($observation) : void
    {
        $this->em->remove($observation);
        $this->em->flush();
    }

    public function persist($observation) : void
    {
        $this->em->persist($observation);
        $this->em->flush();
    }
}