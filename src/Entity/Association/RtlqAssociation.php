<?php

namespace App\Entity\Association;

use App\Entity\AbstractRtlqEntity;
use Doctrine\ORM\Mapping as ORM;



/**
 * RtlqAssociation
 *
 * @ORM\Table(name="rtlq_association", 
 * uniqueConstraints={@ORM\UniqueConstraint(name="nom", columns={"nom"})}, 
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class RtlqAssociation  extends AbstractRtlqEntity
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="date", nullable=false)
     */
    private $date_creation;
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;

        return $this;
    }
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }
    public function getActive()
    {
        return $this->active;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="siege_social", type="string", length=100, nullable=false)
     */
    private $siege_social;
    public function setSiegeSocial($siege_social)
    {
        $this->siege_social = $siege_social;
        return $this;
    }
    public function getSiegeSocial()
    {
        return $this->siege_social;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="numero_siren", type="string", length=100, nullable=false)
     */
    private $numero_siren;
    public function setNumeroSiren($value)
    {
        $this->numero_siren = $value;
        return $this;
    }
    public function getNumeroSiren()
    {
        return $this->numero_siren;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * @var string
     * @ORM\Column(name="url_extranet", type="string", length=100, nullable=true)
     */
    private $url_extranet;
    public function setUrlExtranet($value)
    {
        $this->url_extranet = $value;
        return $this;
    }
    public function getUrlExtranet()
    {
        return $this->url_extranet;
    }


    /**
     * @var string
     * @ORM\Column(name="url_intranet", type="string", length=100, nullable=true)
     */
    private $url_intranet;
    public function setUrlIntranet($value)
    {
        $this->url_intranet = $value;
        return $this;
    }
    public function getUrlIntranet()
    {
        return $this->url_intranet;
    }

    /**
     * @var string
     * @ORM\Column(name="numero_compte_bancaire", type="string", length=100, nullable=true)
     */
    private $numero_compte_bancaire;
    public function setNumeroCompteBancaire($value)
    {
        $this->numero_compte_bancaire = $value;
        return $this;
    }
    public function getNumeroCompteBancaire()
    {
        return $this->numero_compte_bancaire;
    }
    // TODO ajouter liste des bureaux
}
