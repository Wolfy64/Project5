<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Aves
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $order;

    /**
     * @var string
     */
    private $family;

    /**
     * @var string
     */
    private $scientificName;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $commonName;

    /**
     * @var integer
     */
    private $habitat;

    /**
     * @var ArrayCollection
     */
    private $observations;

    public function __construct()
    {
        $this->observations = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getOrder() : ? string
    {
        return $this->order;
    }

    public function setOrder(string $order) : void
    {
        $this->order;
    }

    public function getFamily() : ? string
    {
        return $this->family;
    }

    public function setFamily(string $family) : void
    {
        $this->family;
    }

    public function getScientificName() : ? string
    {
        return $this->scientificName;
    }

    public function setScientificName(string $scientificName) : void
    {
        $this->scientificName;
    }

    public function getAuthor() : ? string
    {
        return $this->author;
    }

    public function setAuthor(string $author) : void
    {
        $this->author;
    }

    public function getCommonName() : ? string
    {
        return $this->commonName;
    }

    public function setCommonName(string $commonName) : void
    {
        $this->commonName;
    }

    public function getHabitat() : ? int
    {
        return $this->habitat;
    }

    public function setHabitat(int $habitat) : void
    {
        $this->habitat;
    }

    public function getObservations() : ArrayCollection
    {
        return $this->observations;
    }

    public function addObservation(Observation $observation) : void
    {
        $this->observations[] = $observation;
    }
}