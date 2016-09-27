<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 * @Vich\Uploadable
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your surname.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="The surname is too short.",
     *     maxMessage="The surname is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     *
     */
    private $aboutMe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $country;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="creationTime", type="datetime")
    */
    private $creationTime;

    /**
     *
     * @ORM\OneToMany(targetEntity="Location", mappedBy="user")
     * @ORM\OrderBy({"dateIns"="DESC"})
     */
    private $location;

    /**
     *
     * @ORM\OneToMany(targetEntity="Review", mappedBy="user")
     * @ORM\OrderBy({"dateIns"="DESC"})
     */
    private $review;

    /**
     *
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="user")
     * @ORM\OrderBy({"dateIns"="DESC"})
     */
    private $activity;

    /**
     *
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="user")
     * @ORM\OrderBy({"dateIns"="DESC"})
     */
    private $photo;

    /**
     *
     * @ORM\OneToMany(targetEntity="Blog", mappedBy="user")
     * @ORM\OrderBy({"dateIns"="DESC"})
     */
    private $blog;
    
    /**
     * @Assert\Image(
     *   maxWidth = 800,maxHeight=800, maxSize = "1024k")     
     * 
     * @Vich\UploadableField(mapping="profile_image", fileNameProperty="imageName", nullable=true)
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;
    
    public function __construct()
    {
        parent::__construct();
        $this->location = new ArrayCollection();
        $this->review = new ArrayCollection();
        $this->photo = new ArrayCollection();
        $this->blog = new ArrayCollection();
        $this->activity = new ArrayCollection();
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Product
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
     * @return Product
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
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set creationTime
     *
     * @param \DateTime $creationTime
     *
     * @return User
     */
    public function setCreationTime($creationTime)
    {
        $this->creationTime = new \DateTime('now');

        return $this;
    }

    /**
     * Get creationTime
     *
     * @return \DateTime
     */
    public function getCreationTime()
    {
        return $this->creationTime;
    }


    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
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
     * Gets the value of location.
     *
     * @return ArrayCollection|Location[]
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Gets the value of review.
     *
     * @return ArrayCollection|Review[]
     */
    public function getReview()
    {
        return $this->review;
    }


    /**
     * Gets the value of photo.
     *
     * @return ArrayCollection|Photo[]
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Gets the value of blog.
     *
     * @return ArrayCollection|Blog[]
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * Gets the value of activity.
     *
     * @return ArrayCollection|Activity[]
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set aboutMe
     *
     * @param string $aboutMe
     *
     * @return User
     */
    public function setAboutMe($aboutMe)
    {
        $this->aboutMe = $aboutMe;

        return $this;
    }

    /**
     * Get aboutMe
     *
     * @return string
     */
    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    /**
     * Add location
     *
     * @param \AppBundle\Entity\Location $location
     *
     * @return User
     */
    public function addLocation(\AppBundle\Entity\Location $location)
    {
        $this->location[] = $location;

        return $this;
    }

    /**
     * Remove location
     *
     * @param \AppBundle\Entity\Location $location
     */
    public function removeLocation(\AppBundle\Entity\Location $location)
    {
        $this->location->removeElement($location);
    }

    /**
     * Add review
     *
     * @param \AppBundle\Entity\Review $review
     *
     * @return User
     */
    public function addReview(\AppBundle\Entity\Review $review)
    {
        $this->review[] = $review;

        return $this;
    }

    /**
     * Remove review
     *
     * @param \AppBundle\Entity\Review $review
     */
    public function removeReview(\AppBundle\Entity\Review $review)
    {
        $this->review->removeElement($review);
    }

    /**
     * Add photo
     *
     * @param \AppBundle\Entity\Photo $photo
     *
     * @return User
     */
    public function addPhoto(\AppBundle\Entity\Photo $photo)
    {
        $this->photo[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \AppBundle\Entity\Photo $photo
     */
    public function removePhoto(\AppBundle\Entity\Photo $photo)
    {
        $this->photo->removeElement($photo);
    }
}
