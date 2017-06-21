<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 5/12/2017
 * Time: 1:35 AM
 */

namespace Eship\EventBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Owner
 *
 * @ORM\Table(name="owner")
 * @ORM\Entity(repositoryClass="Eship\EventBundle\Repository\OwnerRepository")
 */
class Owner
{
    /**
     * @var string
     *
     * @ORM\Column(name="ownerId", type="string", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $ownerId;

    /**
     * @var string
     * @ORM\Column(name="clientEmail", type="string", length=255, unique=true)
     */
    private $ownerEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="initial", type="string", length=255)
     */
    private $initial;

    /**
     * @ORM\OneToMany(targetEntity="Eship\EventBundle\Entity\Business", mappedBy="owner")
     */
    private $business;

    /**
     * @ORM\OneToMany(targetEntity="Eship\EventBundle\Entity\Client", mappedBy="owner")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="Eship\EventBundle\Entity\CNDEOwner", mappedBy="owner")
     */
    private $cndeOwner;

    /**
     * @return string
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @return string
     */
    public function getOwnerEmail()
    {
        return $this->ownerEmail;
    }

    /**
     * @param string $ownerEmail
     */
    public function setOwnerEmail($ownerEmail)
    {
        $this->ownerEmail = $ownerEmail;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getInitial()
    {
        return $this->initial;
    }

    /**
     * @param string $initial
     */
    public function setInitial($initial)
    {
        $this->initial = $initial;
    }

    /**
     * @return mixed
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return mixed
     */
    public function getCndeOwner()
    {
        return $this->cndeOwner;
    }
}