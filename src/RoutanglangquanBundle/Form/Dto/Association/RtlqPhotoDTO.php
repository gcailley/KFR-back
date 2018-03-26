<?php

namespace RoutanglangquanBundle\Form\Dto\Association;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqPhotoDTO extends AbstractRtlqDTO
{
    
    protected $title;
    protected $description;
    protected $source;
    protected $repertoire_id;
    protected $repertoire_name;
    
    public function __construct()
    {
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }
    
    public function getSource()
    {
        return $this->source;
    }
    public function getRepertoireId()
    {
        return $this->repertoire_id;
    }
    public function getRepertoireName()
    {
        return $this->repertoire_name;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setSource($value)
    {
        $this->source = $value;
        return $this;
    }

    public function setRepertoireId($value)
    {
        $this->repertoire_id = $value;
        return $this;
    }
    
    public function setRepertoireName($value)
    {
        $this->repertoire_name = $value;
        return $this;
    }
}
