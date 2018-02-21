<?php

namespace App\Service;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Observation;
use App\Form\MapType;

class MapService
{
    private $em;
    private $form;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $form, SessionInterface $session)
    {
        $this->em = $em;
        $this->form = $form;
        $this->session = $session;
    }

    public function form($request)
    {
        $observation = new Observation();

        $form = $this->form->create(MapType::class, $observation);
        $form->handleRequest($request);

        return $form;
    }

    public function findBy($commonName)
    {
        $observations = $this->em->getRepository(Observation::class)->findBy([
            'commonName' => $commonName,
            'isValid' => true,
        ]);

        if ($observations){
            $this->session->set('observations', $observations);
        }

        return $observations;
    }
}