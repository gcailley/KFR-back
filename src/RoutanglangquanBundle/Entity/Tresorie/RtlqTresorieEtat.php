<?php

namespace RoutanglangquanBundle\Entity\Tresorie;

use Doctrine\ORM\Mapping as ORM;
use RoutanglangquanBundle\Entity\AbstractRtlqEntity;

/**
 * RtlqTresorieEtat
 *
 * @ORM\Table(name="rtlq_tresorie_etat", 
 * uniqueConstraints={@ORM\UniqueConstraint(name="value", columns={"value"})})
 * @ORM\Entity
 */
class RtlqTresorieEtat extends AbstractRtlqEntity
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
     * @ORM\Column(name="value", type="string", length=150, nullable=false)
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
     * Set id
     *
     * @param string $id
     *
     * @return RtlqTresorieEtat
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }    
    /**
     * Set value
     *
     * @param string $value
     *
     * @return RtlqTresorieEtat
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
