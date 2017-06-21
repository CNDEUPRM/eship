<?php

namespace Eship\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eship\EventBundle\Entity\Business;
use Eship\EventBundle\Entity\Counselor;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * BusinessGrowth
 *
 * @ORM\Table(name="business_growth")
 * @ORM\Entity(repositoryClass="Eship\EventBundle\Repository\BusinessGrowthRepository")
 */
class BusinessGrowth
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="bGrowth_id", type="string")
     */
    private $bGrowthId;
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="stage", type="string", length=255)
     */
    private $stage;

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="task", type="string", length=255)
     */
    private $task;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Eship\EventBundle\Entity\Business", inversedBy="businessGrowth")
     * @ORM\JoinColumn(name="business_id", referencedColumnName="business_id")
     */
    private $business;

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
     * @return int
     */
    public function getBGrowthId()
    {
        return $this->bGrowthId;
    }

    /**
     * @param int $bGrowthId
     */
    public function setBGrowthId($bGrowthId)
    {
        $this->bGrowthId = $bGrowthId;
    }

    /**
     * Set stage
     *
     * @param string $stage
     * @return BusinessGrowth
     */

    public function setStage($stage)
    {
        $this->stage = $stage;

        return $this;
    }

    /**
     * Get stage
     *
     * @return string 
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * Set task
     *
     * @param string $task
     * @return BusinessGrowth
     */
    public function setTask($task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return string 
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return BusinessGrowth
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
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

}
