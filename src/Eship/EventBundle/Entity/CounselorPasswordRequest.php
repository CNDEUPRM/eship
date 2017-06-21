<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 5/23/17
 * Time: 3:42 PM
 */

namespace Eship\EventBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="counselor_password_request")
 */
class CounselorPasswordRequest
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
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expirationDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasBeenUsed;

    /**
     * @ORM\ManyToOne(targetEntity="Eship\EventBundle\Entity\Counselor")
     * @ORM\JoinColumn(name="counselorId", referencedColumnName="counselorId", nullable=false)
     */
    private $counselor;

    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param mixed $expirationDate
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }

    /**
     * @return mixed
     */
    public function getHasBeenUsed()
    {
        return $this->hasBeenUsed;
    }

    /**
     * @param mixed $hasBeenUsed
     */
    public function setHasBeenUsed($hasBeenUsed)
    {
        $this->hasBeenUsed = $hasBeenUsed;
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