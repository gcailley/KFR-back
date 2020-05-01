<?php

namespace App\Form\Dto\Association;

use App\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqDriveDTO extends AbstractRtlqDTO
{
    protected $name;
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    protected $filename;
    public function getFilename()
    {
        return $this->filename;
    }

    public function setfilename($value)
    {
        $this->filename = $value;
        return $this;
    }

    protected $type;
    public function getType()
    {
        return $this->type;
    }

    public function setType($value)
    {
        $this->type = $value;
        return $this;
    }

    protected $size;
    public function getSize()
    {
        return $this->size;
    }

    public function setSize($value)
    {
        $this->size = $value;
        return $this;
    }

    protected $thumbnail;    
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    protected $source;
    public function getSource()
    {
        return $this->source;
    }

    public function setSource($value)
    {
        $this->source = $value;
        return $this;
    }

    protected $converting;
    public function getConverting()
    {
        return $this->converting;
    }

    public function setConverting($value)
    {
        $this->converting = $value;
        return $this;
    }
}
