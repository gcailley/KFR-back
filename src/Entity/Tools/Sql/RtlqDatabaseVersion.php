<?php

namespace App\Entity\Tools\Sql;

use Doctrine\ORM\Mapping as ORM;

/**
 * RtlqDatabaseVersion
 *
 * @ORM\Table(name="rtlq_database_version",
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class RtlqDatabaseVersion {



    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @var string @ORM\Column(name="resource_name", type="string", length=500, nullable=false)
     */
    private $resourceName;
    public function setResourceName($resourceName) {
        $this->resourceName = $resourceName;

        return $this;
    }
    public function getResourceName() {
        return $this->resourceName;
    }

    /**
     * @var boolean
     *
     * @ORM\Column(name="etat", type="boolean", nullable=false)
     */
    private $etat;
    public function setEtat($etat) {
        $this->etat = $etat;

        return $this;
    }
    public function getEtat() {
        return $this->etat;
    }
}
