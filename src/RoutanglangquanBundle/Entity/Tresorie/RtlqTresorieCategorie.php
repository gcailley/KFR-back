<?php

namespace RoutanglangquanBundle\Entity\Tresorie;

use Doctrine\ORM\Mapping as ORM;
use RoutanglangquanBundle\Entity\AbstractRtlqEntity;

/**
 * RtlqCategorie
 *
 * @ORM\Table(name="rtlq_tresorie_categorie", 
 * uniqueConstraints={@ORM\UniqueConstraint(name="Value", columns={"Value"})}, 
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class RtlqTresorieCategorie extends AbstractRtlqEntity
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
     * @ORM\Column(name="value", type="string", length=100, nullable=false)
     */
    private $value;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set catId
     *
     * @param string $id
     *
     * @return RtlqTresorieCategorie
     */
    public function setId($id)
    {
    	$this->id = $id;
    
    	return $this;
    }
    
    
    /**
     * Set catValue
     *
     * @param string $value
     *
     * @return RtlqTresorieCategorie
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get Value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
