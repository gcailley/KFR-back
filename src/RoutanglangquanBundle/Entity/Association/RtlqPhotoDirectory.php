<?php

namespace RoutanglangquanBundle\Entity\Association;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use RoutanglangquanBundle\Entity\AbstractRtlqEntity;

/**
 * RtlqNews
 *
 * @ORM\Table(name="rtlq_photo_directories")
 * @ORM\Entity
 */
class RtlqPhotoDirectory extends AbstractRtlqEntity
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
     * @ORM\Column(name="name", type="string", length=1000, nullable=true)
     */
    private $name;
    

    public function __construct()
    {
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}
