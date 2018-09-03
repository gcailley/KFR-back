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

    
    public function __construct()
    {
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function setNom($value)
    {
        $this->nom = $value;
        return $this;
    }
}
