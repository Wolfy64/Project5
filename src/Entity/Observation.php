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

    const DEPARTMENT_LIST = [
        1   => '01 - Ain',
		2   => '02 - Aisne',
		3   => '03 - Allier',
		4   => '04 - Alpes de Haute Provence',
		5   => '05 - Hautes Alpes',
		6   => '06 - Alpes Maritimes',
		7   => '07 - Ardèche',
		8   => '08 - Ardennes',
		9   => '09 - Ariège',
		10  => '10 - Aube',
		11  => '11 - Aude',
		12  => '12 - Aveyron',
		13  => '13 - Bouches du Rhône',
		14  => '14 - Calvados',
		15  => '15 - Cantal',
		16  => '16 - Charente',
		17  => '17 - Charente Maritime',
		18  => '18 - Cher',
		19  => '19 - Corrèze',
		201 => '2A - Corse du Sud',
		202 => '2B - Haute Corse',
		21  => '21 - Côte d\'Or',
		22  => '22 - Côtes d\'Armor',
		23  => '23 - Creuse',
		24  => '24 - Dordogne',
		25  => '25 - Doubs',
		26  => '26 - Drôme',
		27  => '27 - Eure',
		28  => '28 - Eure et Loir',
		29  => '29 - Finistère',
		30  => '30 - Gard',
		31  => '31 - Haute Garonne',
		32  => '32 - Gers',
		33  => '33 - Gironde',
		34  => '34 - Hérault',
		35  => '35 - Ille et Vilaine',
		36  => '36 - Indre',
		37  => '37 - Indre et Loire',
		38  => '38 - Isère',
		39  => '39 - Jura',
		40  => '40 - Landes',
		41  => '41 - Loir et Cher',
		42  => '42 - Loire',
		43  => '43 - Haute Loire',
		44  => '44 - Loire Atlantique',
		45  => '45 - Loiret',
		46  => '46 - Lot',
		47  => '47 - Lot et Garonne',
		48  => '48 - Lozère',
		49  => '49 - Maine et Loire',
		50  => '50 - Manche',
		51  => '51 - Marne',
		52  => '52 - Haute Marne',
		53  => '53 - Mayenne',
		54  => '54 - Meurthe et Moselle',
		55  => '55 - Meuse',
		56  => '56 - Morbihan',
		57  => '57 - Moselle',
		58  => '58 - Nièvre',
		59  => '59 - Nord',
		60  => '60 - Oise',
		61  => '61 - Orne',
		62  => '62 - Pas de Calais',
		63  => '63 - Puy de Dôme',
		64  => '64 - Pyrénées Atlantiques',
		65  => '65 - Hautes Pyrénées',
		66  => '66 - Pyrénées Orientales',
		67  => '67 - Bas Rhin',
		68  => '68 - Haut Rhin',
		69  => '69 - Rhône',
		70  => '70 - Haute Saône',
		71  => '71 - Saône et Loire',
		72  => '72 - Sarthe',
		73  => '73 - Savoie',
		74  => '74 - Haute Savoie',
		75  => '75 - Paris',
		76  => '76 - Seine Maritime',
		77  => '77 - Seine et Marne',
		78  => '78 - Yvelines',
		79  => '79 - Deux Sèvres',
		80  => '80 - Somme',
		81  => '81 - Tarn',
		82  => '82 - Tarn et Garonne',
		83  => '83 - Var',
		84  => '84 - Vaucluse',
		85  => '85 - Vendée',
		86  => '86 - Vienne',
		87  => '87 - Haute Vienne',
		88  => '88 - Vosges',
		89  => '89 - Yonne',
		90  => '90 - Territoire de Belfort',
		91  => '91 - Essonne',
		92  => '92 - Hauts de Seine',
		93  => '93 - Seine St Denis',
		94  => '94 - Val de Marne',
		95  => '95 - Val d\'Oise',
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
     * @var string
     */
    private $department;

    /**
     * @var string
     */
    private $country;

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

    /**
     * @var User
     */
    private $user;

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

    public function getDepartment() : ? int
    {
        return $this->department;
    }

    public function setDepartment(string $department) : void
    {
        $this->department = $department;
    }

    public function getCountry() : ? string
    {
        return $this->country;
    }

    public function setCountry(string $country) : void
    {
        $this->country = $country;
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

    public function getUser() : ? User
    {
        return $this->user;
    }

    public function setUser(User $user) : void
    {
        $this->user = $user;
    }

    public function __toString()
    {
        return $this->getUser();
    }
}
