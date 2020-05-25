<?php

namespace App\Form\Builder\Association;

use App\Entity\Association\RtlqPhoto;
use App\Form\Dto\Association\RtlqPhotoDirectoryDTO;
use App\Entity\Association\RtlqPhotoDirectory;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Builder\Association\RtlqAdherentBuilder;
use App\Form\Dto\Association\RtlqPhotoDTO;

class RtlqPhotoDirectoryBuilder extends AbstractRtlqBuilder
{

    private $rtlqPhotoBuilder;

    public function __construct()
    {
        $this->rtlqPhotoBuilder = new RtlqPhotoBuilder();
    }


    public function dtoToModele($em, $dto, $modele)
    {

        $modele->setName($dto->getNom());
        $modele->setActif($dto->getActif());
        return $modele;
    }


    public function modeleToDto($modele, $dtoClass)
    {
        $dto = $this->getNewDto($dtoClass);

        $dto->setId($modele->getId());
        $dto->setNom($modele->getName());
        $dto->setActif($modele->getActif());
        $dto->setNbPhotos(sizeof($modele->getPhotos()));
        $photos = $modele->getPhotos();
        if ($photos && sizeof($photos) > 0) {
            $photoDto = $this->rtlqPhotoBuilder->modeleToDto($photos[random_int(0, sizeof($photos)-1)], RtlqPhotoDTO::class);
            $dto->setPreviewId($photoDto->getId());
        }

        return $dto;
    }
}
