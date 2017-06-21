<?php

namespace Eship\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eship\EventBundle\Entity\Counselor;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PerformanceReview
 *
 * @ORM\Table(name="performance_review")
 * @ORM\Entity(repositoryClass="Eship\EventBundle\Repository\PerformanceReviewRepository")
 */
class PerformanceReview
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="performance_review_id", type="string", unique=true)
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $performanceReviewId;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(name="clientEmail", type="string", length=255)
     */
    private $clientEmail;

    /**
     * @var string
     * @ORM\Column(name="clientFirstName", type="string", length=255)
     */
    private $clientFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="clientLastName", type="string", length=255)
     */
    private $clientLastName;

    /**
     * @var int
     *
     * @ORM\Column(name="satisfactionLevel", type="integer")
     */
    private $satisfactionLevel;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var bool
     *
     * @ORM\Column(name="usefulnessOfService", type="boolean")
     */
    private $usefulnessOfService;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=15)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="Eship\EventBundle\Entity\Counselor")
     * @ORM\JoinColumn(name="counselorId", referencedColumnName="counselorId")
     */
    private $counselor;

    /**
     * @return mixed
     */
    public function getCounselor()
    {
        return $this->counselor;
    }

    /**
     * @param Counselor $counselor
     */
    public function setCounselor(Counselor $counselor)
    {
        $this->counselor = $counselor;
    }

    /**
     * @return int
     */
    public function getPerformanceReviewId()
    {
        return $this->performanceReviewId;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return PerformanceReview
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set clientEmail
     *
     * @param string $clientEmail
     * @return PerformanceReview
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
     * Set clientFirstName
     *
     * @param string $clientFirstName
     * @return PerformanceReview
     */
    public function setClientFirstName($clientFirstName)
    {
        $this->clientFirstName = $clientFirstName;

        return $this;
    }

    /**
     * Get clientFirstName
     *
     * @return string 
     */
    public function getClientFirstName()
    {
        return $this->clientFirstName;
    }

    /**
     * Set clientLastName
     *
     * @param string $clientLastName
     * @return PerformanceReview
     */
    public function setClientLastName($clientLastName)
    {
        $this->clientLastName = $clientLastName;

        return $this;
    }

    /**
     * Get clientLastName
     *
     * @return string 
     */
    public function getClientLastName()
    {
        return $this->clientLastName;
    }

    /**
     * Set satisfactionLevel
     *
     * @param integer $satisfactionLevel
     * @return PerformanceReview
     */
    public function setSatisfactionLevel($satisfactionLevel)
    {
        $this->satisfactionLevel = $satisfactionLevel;

        return $this;
    }

    /**
     * Get satisfactionLevel
     *
     * @return integer 
     */
    public function getSatisfactionLevel()
    {
        return $this->satisfactionLevel;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return PerformanceReview
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set usefulnessOfService
     *
     * @param boolean $usefulnessOfService
     * @return PerformanceReview
     */
    public function setUsefulnessOfService($usefulnessOfService)
    {
        $this->usefulnessOfService = $usefulnessOfService;

        return $this;
    }

    /**
     * Get usefulnessOfService
     *
     * @return boolean 
     */
    public function getUsefulnessOfService()
    {
        return $this->usefulnessOfService;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return PerformanceReview
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
     * Set phone
     *
     * @param string $phone
     * @return PerformanceReview
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
}
