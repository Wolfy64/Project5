<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Observation
{
    const NUMBERS_OF_BIRDS = [
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8,
            '9' => 9,
            '10+' => 10
    ];

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $commonName;

    /**
     * @var date
     */
    private $date;

    /**
     * @var string
     */
    private $place;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var integer
     */
    private $numbers;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $content;

    /**
     * @var bool
     */
    private $isValid;

    /**
     * @var ArrayCollection
     */
    private $aveses;

    public function __construct()
    {
        $this->aveses = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getCommonName() : ? string
    {
        return $this->commonName;
    }

    public function setCommonName(string $commonName) : void
    {
        $this->commonName = $commonName;
    }

    public function getDate() : ? \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date) : void
    {
        $this->date = $date;
    }

    public function getPlace() : ? string
    {
        return $this->place;
    }

    public function setPlace(string $place) : void
    {
        $this->place = $place;
    }

    public function getLatitude() : ? string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude) : void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude() : ? string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude) : void
    {
        $this->longitude = $longitude;
    }

    public function getNumbers(): ? int
    {
        return $this->numbers;
    }

    public function getImage() : ? string
    {
        return $this->image;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImage($image) : void
    {
        $this->image = $image;
    }

    public function setNumbers(int $numbers) : void
    {
        $this->numbers = $numbers;
    }

    public function getContent() : ? string
    {
        return $this->content;
    }

    public function setContent(string $content) : void
    {
        $this->content = $content;
    }

    public function getIsValid() : ?  bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid) : void
    {
        $this->isValid = $isValid;
    }

    public function getAveses()
    {
        return $this->aveses;
    }

    public function addAves(Aves $aves) : void
    {
        $this->aveses[] = $aves;
    }

    public function removeAves(Aves $aves) : void
    {
        $this->aveses->removeElement($aves);
    }
}
