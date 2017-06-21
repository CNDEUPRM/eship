<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 5/15/2017
 * Time: 11:06 PM
 */

namespace Eship\EventBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Counselor Request
 *
 * @ORM\Table(name="counselor_request")
 * @ORM\Entity(repositoryClass="Eship\EventBundle\Repository\CounselorRequestRepository")
 */
class CounselorRequest
{
    /**
     * @var string
     *
     * @ORM\Column(name="requestId", type="string", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $requestId;

    /**
     * @ORM\Column(type="string", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $role;

    /**
     * @ORM\Column(type="boolean")
     */
    private $requestStatus;

    /**
     * @ORM\ManyToOne(targetEntity="Eship\EventBundle\Entity\Counselor")
     * @ORM\JoinColumn(name="counselorId", referencedColumnName="counselorId")
     */
    private $counselor;

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @param mixed $requestId
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getRequestStatus()
    {
        return $this->requestStatus;
    }

    /**
     * @param mixed $requestStatus
     */
    public function setRequestStatus($requestStatus)
    {
        $this->requestStatus = $requestStatus;
    }

    /**
     * @param mixed $counselor
     */
    public function setCounselor($counselor)
    {
        $this->counselor = $counselor;
    }
}