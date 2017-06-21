<?php

namespace Eship\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eship\EventBundle\Entity\Owner;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="Eship\EventBundle\Repository\ClientRepository")
 */
class Client implements UserInterface
{
    /**
     * @ORM\Id
     * @var string
     * @ORM\Column(name="clientId", type="string", unique=true)
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $clientId;

    /**
     * @var string
     * @ORM\Column(name="clientEmail", type="string", length=255, unique=true)
     */
    private $clientEmail;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=6)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=15)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="relationship_with_UPRM", type="string", length=255)
     */
    private $relationshipWithUPRM;

    /**
     * @var string
     *
     * @ORM\Column(name="department", type="string", length=255)
     */
    private $department;

    /**
     * @var string
     *
     * @ORM\Column(name="business_not_CNDE", type="text")
     */
    private $businessNotCNDE;

    /**
     * @var string
     *
     * @ORM\Column(name="learn_of_services", type="string", length=255)
     */
    private $learnOfServices;

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", length=255)
     */
    private $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=255, nullable=true)
     */
    private $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="zipCode", type="string", length=255)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="Eship\EventBundle\Entity\Owner", inversedBy="client")
     * @ORM\JoinColumn(name="ownerId", referencedColumnName="ownerId", nullable=false)
     */
    private $owner;

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
     * @return int
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set clientEmail
     *
     * @param string $clientEmail
     * @return Client
     */
    public function setClientEmail($clientEmail)
    {
        $this->clientEmail = $clientEmail;

        return $this;
    }

    /**
     * Get clientEmail
     *
     * @return string 
     */
    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return Client
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Client
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Client
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set relationshipWithUPRM
     *
     * @param string $relationshipWithUPRM
     * @return Client
     */
    public function setRelationshipWithUPRM($relationshipWithUPRM)
    {
        $this->relationshipWithUPRM = $relationshipWithUPRM;

        return $this;
    }

    /**
     * Get relationshipWithUPRM
     *
     * @return string 
     */
    public function getRelationshipWithUPRM()
    {
        return $this->relationshipWithUPRM;
    }


    /**
     * Set department
     *
     * @param string $department
     * @return Client
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string 
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set businessNotCNDE
     *
     * @param string $businessNotCNDE
     * @return Client
     */
    public function setBusinessNotCNDE($businessNotCNDE)
    {
        $this->businessNotCNDE = $businessNotCNDE;

        return $this;
    }

    /**
     * Get businessNotCNDE
     *
     * @return string 
     */
    public function getBusinessNotCNDE()
    {
        return $this->businessNotCNDE;
    }

    /**
     * Set learnOfServices
     *
     * @param string $learnOfServices
     * @return Client
     */
    public function setLearnOfServices($learnOfServices)
    {
        $this->learnOfServices = $learnOfServices;

        return $this;
    }

    /**
     * Get learnOfServices
     *
     * @return string 
     */
    public function getLearnOfServices()
    {
        return $this->learnOfServices;
    }

    /**
     * Set address1
     *
     * @param string $address1
     * @return Client
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string 
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return Client
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Client
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     * @return Client
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string 
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Client
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    public function getRoles()
    {
        return array('ROLE_CLIENT');
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->clientEmail;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }


    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
