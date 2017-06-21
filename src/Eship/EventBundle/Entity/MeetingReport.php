<?php

namespace Eship\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eship\EventBundle\Entity\Business;
use Eship\EventBundle\Entity\Counselor;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MeetingReport
 *
 * @ORM\Table(name="meeting_report")
 * @ORM\Entity(repositoryClass="Eship\EventBundle\Repository\MeetingReportRepository")
 */
class MeetingReport
{

    /**
     * @var string
     *
     * @ORM\Column(name="reportId", type="string", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $reportId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="stageOfDevelopment", type="string", length=255)
     */
    private $stageOfDevelopment;

    /**
     * @var string
     *
     * @ORM\Column(name="discussedIssues", type="text")
     */
    private $discussedIssues;

    /**
     * @var string
     *
     * @ORM\Column(name="suggestionsAndAgreements", type="text")
     */
    private $suggestionsAndAgreements;

    /**
     * @var string
     *
     * @ORM\Column(name="counselorPendingMatters", type="text")
     */
    private $counselorPendingMatters;

    /**
     * @var string
     *
     * @ORM\Column(name="clientPendingMatters", type="text")
     */
    private $clientPendingMatters;

    /**
     * @var int
     *
     * @ORM\Column(name="numberOfEmployees", type="integer")
     */
    private $numberOfEmployees;

    /**
     * @var float
     *
     * @ORM\Column(name="privateInvestment", type="decimal", precision=7, scale=2)
     */
    private $privateInvestment;

    /**
     * @var float
     *
     * @ORM\Column(name="publicInvestment", type="decimal", precision=7, scale=2)
     */
    private $publicInvestment;

    /**
     * @var float
     *
     * @ORM\Column(name="meetingDuration", type="decimal", precision=7, scale=1)
     */
    private $meetingDuration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNextMeeting", type="date", nullable=true)
     */
    private $dateNextMeeting;

    /**
     * @var string
     *
     * @ORM\Column(name="hour_next_meeting", type="string", nullable=true)
     */
    private $hourNextMeeting;

    /**
     * @var string
     *
     * @ORM\Column(name="pdfDocument", type="string", nullable=true)
     */
    private $pdfDocument;

    /**
     * @ORM\ManyToOne(targetEntity="Eship\EventBundle\Entity\Business", inversedBy="meetingReport")
     * @ORM\JoinColumn(name="business_id", referencedColumnName="business_id")
     */
    private $business;

    /**
     * @ORM\OneToMany(targetEntity="Eship\EventBundle\Entity\WorkReport", mappedBy="meetingReport")
     */
    private $workReport;

    /**
     * @return mixed
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * @param Business $business
     */
    public function setBusiness(Business $business)
    {
        $this->business = $business;
    }

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
     * @return mixed
     */
    public function getWorkReport()
    {
        return $this->workReport;
    }


    /**
     * Set reportId
     *
     * @param string $reportId
     * @return MeetingReport
     */
    public function setReportId($reportId)
    {
        $this->reportId = $reportId;

        return $this;
    }

    /**
     * Get reportId
     *
     * @return string 
     */
    public function getReportId()
    {
        return $this->reportId;
    }


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return MeetingReport
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
     * Set stageOfDevelopment
     *
     * @param string $stageOfDevelopment
     * @return MeetingReport
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
     * Set discussedIssues
     *
     * @param string $discussedIssues
     * @return MeetingReport
     */
    public function setDiscussedIssues($discussedIssues)
    {
        $this->discussedIssues = $discussedIssues;

        return $this;
    }

    /**
     * Get discussedIssues
     *
     * @return string 
     */
    public function getDiscussedIssues()
    {
        return $this->discussedIssues;
    }

    /**
     * Set suggestionsAndAgreements
     *
     * @param string $suggestionsAndAgreements
     * @return MeetingReport
     */
    public function setSuggestionsAndAgreements($suggestionsAndAgreements)
    {
        $this->suggestionsAndAgreements = $suggestionsAndAgreements;

        return $this;
    }

    /**
     * Get suggestionsAndAgreements
     *
     * @return string 
     */
    public function getSuggestionsAndAgreements()
    {
        return $this->suggestionsAndAgreements;
    }

    /**
     * Set counselorPendingMatters
     *
     * @param string $counselorPendingMatters
     * @return MeetingReport
     */
    public function setCounselorPendingMatters($counselorPendingMatters)
    {
        $this->counselorPendingMatters = $counselorPendingMatters;

        return $this;
    }

    /**
     * Get counselorPendingMatters
     *
     * @return string 
     */
    public function getCounselorPendingMatters()
    {
        return $this->counselorPendingMatters;
    }

    /**
     * Set clientPendingMatters
     *
     * @param string $clientPendingMatters
     * @return MeetingReport
     */
    public function setClientPendingMatters($clientPendingMatters)
    {
        $this->clientPendingMatters = $clientPendingMatters;

        return $this;
    }

    /**
     * Get clientPendingMatters
     *
     * @return string 
     */
    public function getClientPendingMatters()
    {
        return $this->clientPendingMatters;
    }

    /**
     * Set numberOfEmployees
     *
     * @param integer $numberOfEmployees
     * @return MeetingReport
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
     * Set privateInvestment
     *
     * @param float $privateInvestment
     * @return MeetingReport
     */
    public function setPrivateInvestment($privateInvestment)
    {
        $this->privateInvestment = $privateInvestment;

        return $this;
    }

    /**
     * Get privateInvestment
     *
     * @return float 
     */
    public function getPrivateInvestment()
    {
        return $this->privateInvestment;
    }

    /**
     * Set publicInvestment
     *
     * @param float $publicInvestment
     * @return MeetingReport
     */
    public function setPublicInvestment($publicInvestment)
    {
        $this->publicInvestment = $publicInvestment;

        return $this;
    }

    /**
     * Get publicInvestment
     *
     * @return float 
     */
    public function getPublicInvestment()
    {
        return $this->publicInvestment;
    }

    /**
     * Set meetingDuration
     *
     * @param string $meetingDuration
     * @return MeetingReport
     */
    public function setMeetingDuration($meetingDuration)
    {
        $this->meetingDuration = $meetingDuration;

        return $this;
    }

    /**
     * Get meetingDuration
     *
     * @return string
     */
    public function getMeetingDuration()
    {
        return $this->meetingDuration;
    }

    /**
     * Set dateNextMeeting
     *
     * @param string $dateNextMeeting
     * @return MeetingReport
     */
    public function setDateNextMeeting($dateNextMeeting)
    {
        $this->dateNextMeeting = $dateNextMeeting;

        return $this;
    }

    /**
     * Get dateNextMeeting
     *
     * @return string
     */
    public function getDateNextMeeting()
    {
        return $this->dateNextMeeting;
    }

    /**
     * @return string
     */
    public function getPdfDocument()
    {
        return $this->pdfDocument;
    }

    /**
     * @param string $pdfDocument
     */
    public function setPdfDocument($pdfDocument)
    {
        $this->pdfDocument = $pdfDocument;
    }

    /**
     * @return string
     */
    public function getHourNextMeeting()
    {
        return $this->hourNextMeeting;
    }

    /**
     * @param string $hourNextMeeting
     */
    public function setHourNextMeeting($hourNextMeeting)
    {
        $this->hourNextMeeting = $hourNextMeeting;
    }


}
