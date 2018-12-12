<?php

namespace App\Entity\Tresorie;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractRtlqEntity;

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
     * Id en base pour etat REGLER
     */
    public const REGLER = 5;

    /**
     * Id en base pour etat ENCAISSE
     */
    public const ENCAISSE = 1;

    /**
     * Id en base pour etat ANNULE
     */
    public const ANNULE = 6;

    /**
     * Id en base pour etat A_ENCAISSER
     */
    public const A_ENCAISSER = 0;

    /**
     * Id en base pour etat A_RECLAMER
     */
    public const A_RECLAMER = 2;
    
    /**
     * Id en base pour etat A_REGLER
     */
    public const A_REGLER = 4;
    /**
     * Id en base pour etat ANNULER
     */
    public const ANNULER = 6;
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
     *
     * @var App\Entity\Tresorie\RtlqTresorieEtat 
     * @ORM\ManyToOne(targetEntity="App\Entity\Tresorie\RtlqTresorieEtat", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $nextEtat;

    /**
     * Set etat
     *
     * @param App\Entity\Tresorie\RtlqTresorieEtat $etat        	
     *
     * @return RtlqTresorie
     */
    public function setNextEtat(RtlqTresorieEtat $etat) {
        $this->nextEtat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return App\Entity\Tresorie\RtlqTresorieEtat
     */
    public function getNextEtat() {
        return $this->nextEtat;
    }

    /**
     * Get etat
     *
     * @return Interger
     */
    public function getNextEtatId() {
        return $this->nextEtat == null ? null : $this->nextEtat->getId();
    }


    /**
     * Get etat
     *
     * @return Interger
     */
    public function getNextEtatName() {
        return $this->nextEtat == null ? null : $this->nextEtat->getValue();
    }


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
