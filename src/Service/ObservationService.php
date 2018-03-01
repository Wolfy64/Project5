<?php

namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\FileUploader;
use App\Entity\Observation;
use App\Entity\Aves;

class ObservationService
{
    const NOT_FOUND = 'Cette observation n\'existe pas';
    const HABITAT = [
        1 => 'Marin',
        2 => 'Eau douce',
        3 => 'Terrestre',
        4 => 'Marin & Eau douce',
        5 => 'Marin & Terrestre',
        6 => 'Eau saumâtre',
        7 => 'Continental (terrestre et/ou eau douce)',
        8 => 'Continental (terrestre et/ou eau douce)'
    ];
    const ROLES = [
        'ROLE_ADMIN',
        'ROLE_NATURALIST'
    ];
    const FLASH_MESSAGE = [
        1 => 'Votre observation est enregistré',
        2 => 'Votre observation est en attente de validation par un de nos naturalistes',
        3 => 'Aucun résultat pour la recherche: ',
        4 => 'Attention le nom de l\'oiseau doit correspondre à la base de donnée Aves',
        5 => 'L\'observation à était validé',
        6 => 'L\'observation à était supprimé',
        7 => 'L\'observation à était modifié'
    ];

    private $em;
    private $fileUploader;
    private $token;
    private $message;

    public function __construct(EntityManagerInterface $em, FileUploader $fileUploader, TokenStorageInterface $token)
    {
        $this->em = $em;
        $this->fileUploader = $fileUploader;
        $this->token = $token;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function handle(Observation $observation) : Observation
    {
        $user = $this->token->getToken()->getUser();

        $observation->setUser($user);
        $observation->setIsValid(false);
        $observation->setImage('no_image.png');
        $this->message = self::FLASH_MESSAGE[2];

        $isNaturalist = $this->isNaturalist($user->getRoles()[0]);

        if($isNaturalist){
            $this->message = self::FLASH_MESSAGE[1];
            $observation->setIsValid(true);
        }
        
        return $observation;
    }

    public function hasImage($image, Observation $observation)
    {
        $imageName = $this->fileUploader->upload($image);
        $observation->setImage($imageName);
    }

    public function isNaturalist($userRoles) : bool
    {
        if (in_array($userRoles, self::ROLES)) {
            return true;
        }

        return false;
    }

    public function find(int $id) : ? Observation
    {
        $result = $this->em->getRepository(Observation::class)->find($id);

        if (!$result){
            $this->message = self::NOT_FOUND;
        }
        
        return $result;
    }

    public function findByCommonName(string $commonName) : array
    {
        $result =  $this->em->getRepository(Observation::class)->findBy([
            'commonName' => $commonName,
            'isValid' => true,
        ]);

        if (!$result){
            $this->message = self::FLASH_MESSAGE[3] . $commonName;
        }

        return $result;
    }

    public function findByUser(bool $isValid) : array
    {
        return $this->em->getRepository(Observation::class)->findBy([
            'user' => $this->token->getToken()->getUser()->getId(),
            'isValid' => $isValid,
        ]);
    }

    public function findBy(string $commonName) : ? array
    {
        $result = $this->em->getRepository(Aves::class)->findBy(['commonName' => $commonName]);

        if (!$result) {
            $this->message = self::FLASH_MESSAGE[4];
        }

        return $result;
    }

    public function isPublished(bool $bool) : array
    {
        return $this->em->getRepository(Observation::class)->findBy(['isValid' => $bool]);
    }

    public function doValid(Observation $observation) : void
    {
        $this->addAves($observation);
        $this->persist($observation);
    }

    public function doRemove(Observation $observation) : void
    {
        $this->message = self::FLASH_MESSAGE[6];
        $this->em->remove($observation);
        $this->em->flush();
    }

    public function addAves(Observation $observation) : Observation
    {
        $aveses = $this->findBy($observation->getCommonName());

        foreach ($aveses as $aves) {
            $observation->addAves($aves);
        }

        $nbAveses = count($observation->getAveses());

        if ($nbAveses) {
            $this->message = self::FLASH_MESSAGE[5];
            $observation->setIsValid(true);
        }

        return $observation;
    }

    public function persist(Observation $observation) : void
    {
        $this->em->persist($observation);
        $this->em->flush();
    }

    public function birdInfos(array $observations) : array
    {
        $birdInfos = [];

        $scientificNames = [];
        $authors = [];

        $aveses = $observations[0]->getAveses();

        // Define $habitat
        switch ($aveses[0]->getHabitat()) {
            case '1':
                $habitat = self::HABITAT[1];
                break;
            case '2':
                $habitat = self::HABITAT[2];
                break;
            case '3':
                $habitat = self::HABITAT[3];
                break;
            case '4':
                $habitat = self::HABITAT[4];
                break;
            case '5':
                $habitat = self::HABITAT[5];
                break;
            case '6':
                $habitat = self::HABITAT[6];
                break;
            case '7':
                $habitat = self::HABITAT[7];
                break;
            case '8':
                $habitat = self::HABITAT[8];
                break;
            
            default:
                $habitat = 'Non déterminé';
                break;
        }

        // Fill up $scientificNames[] & $authors[]
        foreach ($aveses as $aves) {
            $scientificNames[] = $aves->getScientificName();
            
            // Remove brackets
            $author = str_replace(['(', ')'], '', $aves->getAuthor());

            // Avoid duplicate author
            if (!in_array($author, $authors)) {
                $authors[] = $author;
            }
        }

        $birdInfos['order'] = $aveses[0]->getOrder();
        $birdInfos['family'] = $aveses[0]->getFamily();
        $birdInfos['commonName'] = $aveses[0]->getCommonName();
        $birdInfos['habitat'] = $habitat;
        $birdInfos['scientificNames'] = $scientificNames;
        $birdInfos['author'] = $authors;

        return $birdInfos;
    }
}