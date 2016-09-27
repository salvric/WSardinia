<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activity
 *
 * @ORM\Table(name="activity")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActivityRepository")
 */
class Activity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="TypeActivity", inversedBy="activity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activity_type;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="activity")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     *
     */
    private $location;

    /**
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="activity")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ins", type="datetime", nullable=false)
     */
    private $dateIns;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Activity
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
     * Set dateIns
     *
     * @param \DateTime $dateIns
     *
     * @return Activity
     */
    public function setDateIns($dateIns)
    {
        $this->dateIns = new \DateTime('now');

        return $this;
    }

    /**
     * Get dateIns
     *
     * @return \DateTime
     */
    public function getDateIns()
    {
        return $this->dateIns;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Activity
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set activityType
     *
     * @param \AppBundle\Entity\TypeActivity $activityType
     *
     * @return Activity
     */
    public function setActivityType(\AppBundle\Entity\TypeActivity $activityType)
    {
        $this->activity_type = $activityType;

        return $this;
    }

    /**
     * Get activityType
     *
     * @return \AppBundle\Entity\TypeActivity
     */
    public function getActivityType()
    {
        return $this->activity_type;
    }

    /**
     * Set location
     *
     * @param \AppBundle\Entity\Location $location
     *
     * @return Activity
     */
    public function setLocation(\AppBundle\Entity\Location $location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \AppBundle\Entity\Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Activity
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
