<?php
namespace RoutanglangquanBundle\Entity\Security;

use Doctrine\ORM\Mapping as ORM;
use RoutanglangquanBundle\Entity\Association\RtlqAdherent as RtlqAdherent;

/**
 * @ORM\Entity()
 * @ORM\Table(name="rtlq_auth_tokens",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="auth_tokens_value_unique", columns={"value"})}
 * )
 */
class RtlqAuthToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $value;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="RoutanglangquanBundle\Entity\Association\RtlqAdherent")
     * @var RtlqAdherent
     */
    protected $user;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(RtlqAdherent $user)
    {
        $this->user = $user;
    }
}