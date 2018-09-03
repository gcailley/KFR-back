<?php

namespace App\Entity\Association;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractRtlqEntity;

/**
 * RtlqNews
 *
 * @ORM\Table(name="rtlq_photo")
 * @ORM\Entity
 */
class RtlqPhoto extends AbstractRtlqEntity
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    private $title;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=false)
     */
    private $description;

    /**
     *
     * @var integer 
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Association\RtlqPhotoDirectory", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $repertoire;

    /**
     *
     * @var string
     */
    private $source_base64;
    
    /**
     *
     * @var string @ORM\Column(name="source_name", type="string", nullable=false)
     */
    private $source_name;

    /**
     *
     * @var string @ORM\Column(name="source_mime_type",  type="string", length=20, nullable=false)
     */
    private $source_mime_type;
    
    /**
     *
     * @var string @ORM\Column(name="source_file_size",  type="string", length=20, nullable=false)
     */
    private $source_file_size;
    
    /**
     *
     * @var string
     */
    private $thumbnail_base64;

    /**
     *
     * @var string @ORM\Column(name="thumbnail_name", type="string", nullable=false)
     */
    private $thumbnail_name;

    /**
     *
     * @var string @ORM\Column(name="thumbnail_mime_type",  type="string", length=20, nullable=false)
     */
    private $thumbnail_mime_type;

    /**
     *
     * @var string @ORM\Column(name="thumbnail_file_size",  type="string", length=20, nullable=false)
     */
    private $thumbnail_file_size;

    public function __construct()
    {
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
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

    public function setRepertoire($value)
    {
        $this->repertoire = $value;
        return $this;
    }

    public function setSourceBase64($value)
    {
        $this->source_base64 = $value;
        return $this;
    }

    public function setSourceMimeType($value)
    {
        $this->source_mime_type = $value;
        return $this;
    }

    public function setSourceFileSize($value)
    {
        $this->source_file_size = $value;
        return $this;
    }

    public function setThumbnailBase64($value)
    {
        $this->thumbnail_base64 = $value;
        return $this;
    }
    public function setThumbnailMimeType($value)
    {
        $this->thumbnail_mime_type = $value;
        return $this;
    }

    public function setThumbnailFileSize($value)
    {
        $this->thumbnail_file_size = $value;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title ;
    }


    public function getDescription()
    {
        return $this->description ;
    }

    public function getRepertoire()
    {
        return $this->repertoire;
    }

    public function getSourceBase64()
    {
        return $this->source_base64;
    }

    public function getSourceMimeType()
    {
        return $this->source_mime_type;
    }

    public function getSourceFileSize()
    {
        return $this->source_file_size;
    }
    
    public function getThumbnailBase64()
    {
        return $this->thumbnail_base64;
    }

    public function getThumbnailMimeType()
    {
        return $this->thumbnail_mime_type;
    }

    public function getThumbnailFileSize()
    {
        return $this->thumbnail_file_size;
    }
    public function getThumbnailName()
    {
        return $this->thumbnail_name;
    }
    public function setThumbnailName($value)
    {
        $this->thumbnail_name = $value;
        return $this;
    }
    public function getSourceName()
    {
        return $this->source_name;
    }
    public function setSourceName($value)
    {
        $this->source_name = $value;
        return $this;
    }
    

}
