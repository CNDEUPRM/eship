<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 5/13/2017
 * Time: 1:30 AM
 */

namespace Eship\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eship\EventBundle\Entity\Owner;
use Eship\EventBundle\Entity\Counselor;


/**
 * @ORM\Entity
 * @ORM\Table(name="cndeowner")
 */
class CNDEOwner
{
    /**
     * @ORM\Id
     * @var string
     * @ORM\Column(name="clientEmail", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="Eship\EventBundle\Entity\Owner", inversedBy="cndeOwner")
     * @ORM\JoinColumn(name="ownerId", referencedColumnName="ownerId", nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="Eship\EventBundle\Entity\Counselor", inversedBy="cndeOwner")
     * @ORM\JoinColumn(name="counselorId", referencedColumnName="counselorId", nullable=false)
     */
    private $counselor;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getCounselor()
    {
        return $this->counselor;
    }

    /**
     * @param mixed $counselor
     */
    public function setCounselor($counselor)
    {
        $this->counselor = $counselor;
    }


}