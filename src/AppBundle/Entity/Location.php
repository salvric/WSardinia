<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;
use AppBundle\Entity\Location;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocationRepository")
 * 
 * @Vich\Uploadable   
 * 
 */
class Location
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * 
     */
    public $name;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="location")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     *
     * @ORM\OneToMany(targetEntity="Review", mappedBy="location")
     * 
     * @ORM\OrderBy({"dateIns"="DESC"})
     */
    private $review;

    /**
     *
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="location")
     * 
     * @ORM\OrderBy({"datePost"="DESC"})
     * 
     */
    private $photo;

    /**
     *
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="location")
     * 
     * @ORM\OrderBy({"dateIns"="DESC"})
     */
    private $activity;

    /**
     * 
     * @Vich\UploadableField(mapping="location_image", fileNameProperty="imageName")
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=3000, nullable=true)
     * @Assert\Length(
     *     min=2,
     *     max=3000,
     *     minMessage="Min 2 car.",
     *     maxMessage="Max 3000 car.")
     */
    private $description;

    /**
     * 
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=8, nullable=true)
     * 
     */
    private $lat;

    /**
     * 
     *
     * @ORM\Column(name="longitude", type="decimal",precision=14, scale=12, nullable=true)
     * 
     */
    private $lng;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ins", type="datetime", nullable=true)
     */
    private $dateIns;
    
    public function __construct()
    {
        $this->review = new ArrayCollection();
        $this->photo = new ArrayCollection();
        $this->activity = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Location
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
     * Set status
     *
     * @param boolean $status
     *
     * @return Location
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateIns
     *
     * @param \DateTime $dateIns
     *
     * @return Location
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Location
     */
    public function setUser(\AppBundle\Entity\User $user = null)
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

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Location
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Location
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
     * Set lat
     *
     * @param string $lat
     *
     * @return Location
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     *
     * @return Location
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /*
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Location
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Location
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Get Review
     *
     * @return ArrayCollection|Review[]
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Get Photo
     *
     * @return ArrayCollection|Photo[]
     */
    public function getPhoto()
    {
        return $this->photo;
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
