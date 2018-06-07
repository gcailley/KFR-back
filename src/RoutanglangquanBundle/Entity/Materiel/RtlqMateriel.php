<?php

namespace RoutanglangquanBundle\Entity\Materiel;

use Doctrine\ORM\Mapping as ORM;

use RoutanglangquanBundle\Entity\AbstractRtlqEntity;

/**
 * RtlqCotisation
 *
 * @ORM\Table(name="rtlq_materiel",
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class RtlqMateriel extends AbstractRtlqEntity{


    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }
    public  function getId() {
        return $this->id;
    }


    /**
     *
     * @var string @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;
    public function setNom($value)
    {
        $this->nom = $value;
        return $this;
    }
    public  function getNom() {
        return $this->nom;
    }


    /**
     *
     * @var string @ORM\Column(name="prix_achat", type="float", nullable=false)
     */
    private $prixAchat;
    public function setPrixAchat($value)
    {
        $this->prixAchat = $value;
        return $this;
    }
    public  function getPrixAchat() {
        return $this->prixAchat;
    }

    /**
     *
     * @var string @ORM\Column(name="prix_vente", type="float", nullable=false)
     */
    private $prixVente;
    public function setPrixVente($value)
    {
        $this->prixVente = $value;
        return $this;
    }
    public  function getPrixVente() {
        return $this->prixVente;
    }

    /**
     *
     * @var string @ORM\Column(name="stock", type="integer", nullable=false)
     */
    protected $stock = 0;
    public function getStock() {
        return $this->stock;
    }
    public function setStock($value) {
        $this->stock = $value;
        return $this;
    }

    /**
     *
     * @var string @ORM\Column(name="association", type="boolean", nullable=false)
     */
    private $association = false;
    public function setAssociation($value)
    {
        $this->association = $value;
        return $this;
    }
    public  function getAssociation() {
        return $this->association;
    }


    /**
     *
     * @var string @ORM\Column(name="date_achat", type="datetime", nullable=false)
     */
    private $dateAchat;
    public function setDateAchat($value)
    {
        $this->dateAchat = $value;
        return $this;
    }
    public  function getDateAchat() {
        return $this->dateAchat;
    }
}
