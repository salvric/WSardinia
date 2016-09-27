<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Activity;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * TypeActivity
 *
 * @ORM\Table(name="type_activity")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeActivityRepository")
 */
class TypeActivity
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
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="activity_type")
     * 
     */
    private $activity;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    public function __construct()
    {
        $this->activity = new ArrayCollection();
    }
    
    public function __toString() 
    {
        return $this->type;
    }

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
     * Set type
     *
     * @param string $type
     *
     * @return TypeActivity
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Get Activity
     *
     * @return ArrayCollection|Activity[]
     */
    public function getActivity()
    {
        return $this->activity;
    }
}

