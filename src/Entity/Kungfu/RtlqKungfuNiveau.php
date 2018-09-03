<?php

namespace App\Entity\Kungfu;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractRtlqEntity;

/**
 * RtlqKungfuNiveau
 *
 * @ORM\Table(name="rtlq_kungfu_niveau", 
 * uniqueConstraints={@ORM\UniqueConstraint(name="Value", columns={"Value"})}, 
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class RtlqKungfuNiveau extends AbstractRtlqEntity
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
     * @return RtlqKungfuNiveau
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
     * @return RtlqKungfuNiveau
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
