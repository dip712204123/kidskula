<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskullaSchools
 *
 * @ORM\Table(name="kidskulla_schools")
 * @ORM\Entity
 */
class KidskullaSchools
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="school_name", type="string", length=255, nullable=false)
     */
    private $schoolName;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=45, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=45, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="logitude", type="string", length=45, nullable=true)
     */
    private $logitude;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Bundle\AdminBundle\Entity\KidskulaUsers", inversedBy="kidskullaSchools")
     * @ORM\JoinTable(name="kidskulla_schools_has_kidskula_users",
     *   joinColumns={
     *     @ORM\JoinColumn(name="kidskulla_schools_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="kidskula_users_user_id", referencedColumnName="id")
     *   }
     * )
     */
    private $kidskulaUsersUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kidskulaUsersUser = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set schoolName
     *
     * @param string $schoolName
     * @return KidskullaSchools
     */
    public function setSchoolName($schoolName)
    {
        $this->schoolName = $schoolName;

        return $this;
    }

    /**
     * Get schoolName
     *
     * @return string 
     */
    public function getSchoolName()
    {
        return $this->schoolName;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return KidskullaSchools
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return KidskullaSchools
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return KidskullaSchools
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set logitude
     *
     * @param string $logitude
     * @return KidskullaSchools
     */
    public function setLogitude($logitude)
    {
        $this->logitude = $logitude;

        return $this;
    }

    /**
     * Get logitude
     *
     * @return string 
     */
    public function getLogitude()
    {
        return $this->logitude;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return KidskullaSchools
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return KidskullaSchools
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
     * Add kidskulaUsersUser
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $kidskulaUsersUser
     * @return KidskullaSchools
     */
    public function addKidskulaUsersUser(\Bundle\AdminBundle\Entity\KidskulaUsers $kidskulaUsersUser)
    {
        $this->kidskulaUsersUser[] = $kidskulaUsersUser;

        return $this;
    }

    /**
     * Remove kidskulaUsersUser
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $kidskulaUsersUser
     */
    public function removeKidskulaUsersUser(\Bundle\AdminBundle\Entity\KidskulaUsers $kidskulaUsersUser)
    {
        $this->kidskulaUsersUser->removeElement($kidskulaUsersUser);
    }

    /**
     * Get kidskulaUsersUser
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getKidskulaUsersUser()
    {
        return $this->kidskulaUsersUser;
    }
}
