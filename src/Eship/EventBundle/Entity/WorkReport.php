<?php

namespace Eship\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eship\EventBundle\Entity\MeetingReport;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WorkReport
 *
 * @ORM\Table(name="work_report")
 * @ORM\Entity(repositoryClass="Eship\EventBundle\Repository\WorkReportRepository")
 */
class WorkReport
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="updateId", type="string", unique=true)
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $updateId;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text")
     */
    private $notes;

    /**
     * @var float
     *
     * @ORM\Column(name="worked_hours", type="decimal", precision=7, scale=1)
     */
    private $workedHours;

    /**
     * @var string
     *
     * @ORM\Column(name="taskCompleted", type="text")
     */
    private $taskCompleted;

    /**
     * @var string
     *
     * @ORM\Column(name="taskInProgress", type="text", nullable=true)
     */
    private $taskInProgress;

    /**
     * @ORM\ManyToOne(targetEntity="Eship\EventBundle\Entity\MeetingReport", inversedBy="workReport")
     * @ORM\JoinColumn(name="meeting_report_id", referencedColumnName="reportId")
     */
    private $meetingReport;

    /**
     * @ORM\ManyToOne(targetEntity="Eship\EventBundle\Entity\Business", inversedBy="workReport")
     * @ORM\JoinColumn(name="business_id", referencedColumnName="business_id")
     */
    private $business;

    /**
     * @ORM\ManyToOne(targetEntity="Eship\EventBundle\Entity\Counselor")
     * @ORM\JoinColumn(name="counselorId", referencedColumnName="counselorId")
     */
    private $counselor;

    /**
     * @return mixed
     */
    public function getMeetingReport()
    {
        return $this->meetingReport;
    }

    /**
     * @param mixed $meetingReport
     */
    public function setMeetingReport(MeetingReport $meetingReport)
    {
        $this->meetingReport = $meetingReport;
    }

    /**
     * @return mixed
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * @param mixed $business
     */
    public function setBusiness($business)
    {
        $this->business = $business;
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

    /**
     * Set updateId
     *
     * @param string $updateId
     * @return WorkReport
     */
    public function setUpdateId($updateId)
    {
        $this->updateId = $updateId;

        return $this;
    }

    /**
     * Get updateId
     *
     * @return string 
     */
    public function getUpdateId()
    {
        return $this->updateId;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return WorkReport
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
     * Set notes
     *
     * @param string $notes
     * @return WorkReport
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set workedHours
     *
     * @param string $workedHours
     * @return WorkReport
     */
    public function setWorkedHours($workedHours)
    {
        $this->workedHours = $workedHours;

        return $this;
    }

    /**
     * Get workedHours
     *
     * @return string
     */
    public function getWorkedHours()
    {
        return $this->workedHours;
    }

    /**
     * Set taskCompleted
     *
     * @param string $taskCompleted
     * @return WorkReport
     */
    public function setTaskCompleted($taskCompleted)
    {
        $this->taskCompleted = $taskCompleted;

        return $this;
    }

    /**
     * Get taskCompleted
     *
     * @return string 
     */
    public function getTaskCompleted()
    {
        return $this->taskCompleted;
    }

    /**
     * Set taskInProgress
     *
     * @param string $taskInProgress
     * @return WorkReport
     */
    public function setTaskInProgress($taskInProgress)
    {
        $this->taskInProgress = $taskInProgress;

        return $this;
    }

    /**
     * Get taskInProgress
     *
     * @return string 
     */
    public function getTaskInProgress()
    {
        return $this->taskInProgress;
    }
}
