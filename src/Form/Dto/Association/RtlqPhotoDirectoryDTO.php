<?php

namespace App\Form\Dto\Association;

use App\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqPhotoDirectoryDTO extends AbstractRtlqDTO
{
    
    protected $nom;
    public function getNom()
    {
        return $this->nom;
    }
    public function setNom($value)
    {
        $this->nom = $value;
        return $this;
    }

    protected $preview_id;
    public function getPreviewId()
    {
        return $this->preview_id;
    }
    public function setPreviewId($previewId)
    {
        $this->preview_id = $previewId;
        return $this;
    }

    protected $actif;
    public function getActif()
    {
        return $this->actif;
    }
    public function setActif($actif)
    {
        $this->actif = $actif;
        return $this;
    }

    protected $nb_photos;
    public function getNbPhotos()
    {
        return $this->nb_photos;
    }
    public function setNbPhotos($nbPhotos)
    {
        $this->nb_photos = $nbPhotos;
        return $this;
    }


    
    public function __construct()
    {
    }
}
