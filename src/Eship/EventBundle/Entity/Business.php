<?php

namespace Eship\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eship\EventBundle\Entity\Owner;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Business
 *
 * @ORM\Table(name="business")
 * @ORM\Entity(repositoryClass="Eship\EventBundle\Repository\BusinessRepository")
 */
class Business
{
    /**
     * @var string
     *
     * @ORM\Column(name="business_id", type="string", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $business_id;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="businessLink", type="string", length=255)
     */
    private $businessLink;

    /**
     * @var string
     *
     * @ORM\Column(name="stageOfDevelopment", type="string", length=255, nullable=true)
     */
    private $stageOfDevelopment;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="RequestedHelp", type="text")
     */
    private $requestedHelp;

    /**
     * @var int
     *
     * @ORM\Column(name="numberOfEmployees", type="integer")
     */
    private $numberOfEmployees;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255)
     */
    private $logo;

    /**
     * @var bool
     *
     * @ORM\Column(name="isProject", type="boolean")
     */
    private $isProject;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $publicInvestment;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $privateInvestment;

    /**
     * @var bool
     *
     * @ORM\Column(name="participation_business_competition", type="boolean")
     */
    private $participationBusinessCompetition;

    /**
     * @var string
     *
     * @ORM\Column(name="nameCompetition", type="text", nullable=true)
     */
    private $nameCompetition;

    /**
     * @var string
     *
     * @ORM\Column(name="award", type="text", nullable=true)
     */
    private $award;

    /**
     * @var string
     *
     * @ORM\Column(name="type_of_business", type="text", nullable=true)
     */
    private $typeOfBusiness;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="Eship\EventBundle\Entity\Owner", inversedBy="business")
     * @ORM\JoinColumn(name="ownerId", referencedColumnName="ownerId", nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="Eship\EventBundle\Entity\BusinessGrowth", mappedBy="business")
     */
    private $businessGrowth;

    /**
     * @ORM\OneToMany(targetEntity="Eship\EventBundle\Entity\MeetingReport", mappedBy="business")
     */
    private $meetingReport;

    /**
     * @ORM\OneToMany(targetEntity="Eship\EventBundle\Entity\WorkReport", mappedBy="business")
     */
    private $workReport;

    /**
     * @var float
     *
     * @ORM\Column(name="workedHours", type="decimal", precision=7, scale=1, nullable=true)
     */
    private $workedHours;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param Owner $owner
     */
    public function setOwner(Owner $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return int
     */
    public function getBusinessId()
    {
        return $this->business_id;
    }



    /**
     * Set name
     *
     * @param string $name
     * @return Business
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set businessLink
     *
     * @param string $businessLink
     * @return Business
     */
    public function setBusinessLink($businessLink)
    {
        $this->businessLink = $businessLink;

        return $this;
    }

    /**
     * Get businessLink
     *
     * @return string
     */
    public function getBusinessLink()
    {
        return $this->businessLink;
    }

    /**
     * Set stageOfDevelopment
     *
     * @param string $stageOfDevelopment
     * @return Business
     */
    public function setStageOfDevelopment($stageOfDevelopment)
    {
        $this->stageOfDevelopment = $stageOfDevelopment;

        return $this;
    }

    /**
     * Get stageOfDevelopment
     *
     * @return string
     */
    public function getStageOfDevelopment()
    {
        return $this->stageOfDevelopment;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Business
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set requestedHelp
     *
     * @param string $requestedHelp
     * @return Business
     */
    public function setRequestedHelp($requestedHelp)
    {
        $this->requestedHelp = $requestedHelp;

        return $this;
    }

    /**
     * Get requestedHelp
     *
     * @return string
     */
    public function getRequestedHelp()
    {
        return $this->requestedHelp;
    }

    /**
     * Set numberOfEmployees
     *
     * @param integer $numberOfEmployees
     * @return Business
     */
    public function setNumberOfEmployees($numberOfEmployees)
    {
        $this->numberOfEmployees = $numberOfEmployees;

        return $this;
    }

    /**
     * Get numberOfEmployees
     *
     * @return integer
     */
    public function getNumberOfEmployees()
    {
        return $this->numberOfEmployees;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Business
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return Business
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return Business
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Business
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @return bool
     */
    public function isProject()
    {
        return $this->isProject;
    }

    /**
     * @param bool $isProject
     */
    public function setIsProject($isProject)
    {
        $this->isProject = $isProject;
    }



    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Business
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @return mixed
     */
    public function getPublicInvestment()
    {
        return $this->publicInvestment;
    }

    /**
     * @param mixed $publicInvestment
     */
    public function setPublicInvestment($publicInvestment)
    {
        $this->publicInvestment = $publicInvestment;
    }

    /**
     * @return mixed
     */
    public function getPrivateInvestment()
    {
        return $this->privateInvestment;
    }

    /**
     * @param mixed $privateInvestment
     */
    public function setPrivateInvestment($privateInvestment)
    {
        $this->privateInvestment = $privateInvestment;
    }

    /**
     * @return mixed
     */
    public function getParticipationBusinessCompetition()
    {
        return $this->participationBusinessCompetition;
    }

    /**
     * @param mixed $participationBusinessCompetition
     */
    public function setParticipationBusinessCompetition($participationBusinessCompetition)
    {
        $this->participationBusinessCompetition = $participationBusinessCompetition;
    }

    /**
     * @return mixed
     */
    public function getNameCompetition()
    {
        return $this->nameCompetition;
    }

    /**
     * @param mixed $nameCompetition
     */
    public function setNameCompetition($nameCompetition)
    {
        $this->nameCompetition = $nameCompetition;
    }

    /**
     * @return string
     */
    public function getAward()
    {
        return $this->award;
    }

    /**
     * @param string $award
     */
    public function setAward($award)
    {
        $this->award = $award;
    }

    public function businessGrowth__construct()
    {
        $this->businessGrowth = new ArrayCollection();
    }

    public function meetingReport__construct()
    {
        $this->meetingReport = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getBusinessGrowth()
    {
        return $this->businessGrowth;
    }

    /**
     * @return mixed
     */
    public function getMeetingReport()
    {
        return $this->meetingReport;
    }

    /**
     * @return mixed
     */
    public function getWorkReport()
    {
        return $this->workReport;
    }

    /**
     * @return string
     */
    public function getTypeOfBusiness()
    {
        return $this->typeOfBusiness;
    }

    /**
     * @param string $typeOfBusiness
     */
    public function setTypeOfBusiness($typeOfBusiness)
    {
        $this->typeOfBusiness = $typeOfBusiness;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return float
     */
    public function getWorkedHours()
    {
        return $this->workedHours;
    }

    /**
     * @param float $workedHours
     */
    public function setWorkedHours($workedHours)
    {
        $this->workedHours = $workedHours;
    }


}
