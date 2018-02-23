<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Aves;
use App\Entity\Observation;

class AvesService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addAves($observation) : Observation
    {
        $aveses = $this->findBy($observation->getCommonName());

        foreach ($aveses as $aves) {
            $observation->addAveses($aves);
        }

        return $observation;
    }

    public function findBy($commonName) : ? array
    {
        return $this->em->getRepository(Aves::class)->findBy(['commonName' => $commonName]);
    }
}