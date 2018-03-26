<?php

namespace RoutanglangquanBundle\Form\Dto\Association;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqPhotoDirectoryDTO extends AbstractRtlqDTO
{
    
    protected $name;

    
    public function __construct()
    {
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }
}
