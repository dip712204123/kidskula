<?php

namespace Bundle\AdminBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="kidskula_users")
 * @UniqueEntity(fields="username", message="Sorry, this username is already taken.")
 * @UniqueEntity(fields="myavatar", message="Sorry, this avatar name is already taken.")
 */
class KidsKulaUsers extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=50, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=45, nullable=false)
     */
    private $phone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="gender", type="boolean", nullable=false)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="user_state", type="string", length=50, nullable=false)
     */
    private $userState;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=50, nullable=false)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="security_code", type="string", length=255, nullable=false)
     */
    private $securityCode;
    
    
    /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaStudentAvatar
     *
     * @ORM\OneToOne(targetEntity="Bundle\AdminBundle\Entity\KidsKulaStudentAvatar")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="avatarid", referencedColumnName="id", unique=false)
     * })
     */
    private $avatarid;
    /**
     * @var string
     *
     * @ORM\Column(name="myavatar", type="string", length=255, nullable=true)
     */
    private $myavatar;

    /**
     * @var string
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var string
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=false)
     */
    private $datemodified;

    /**
     * @var string
     *
     * @ORM\Column(name="recov_email", type="string", length=255, nullable=false)
     */
    private $recovemail;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    public function setUserState($userState) {
        $this->userState = $userState;
        return $this;
    }

    public function getUserState() {
        return $this->userState;
    }

    public function setCity($city) {
        $this->city = $city;
        return $this;
    }

    public function getCity() {
        return $this->city;
    }

    public function setZip($zip) {
        $this->zip = $zip;
        return $this;
    }

    public function getZip() {
        return $this->zip;
    }

    public function setSecurityCode($securityCode) {
        $this->securityCode = $securityCode;
        return $this;
    }

    public function getSecurityCode() {
        return $this->securityCode;
    }

    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function getRecovemail() {
        return $this->recovemail;
    }

    public function getDatemodified() {
        return $this->datemodified;
    }

    public function setDatemodified($datemodified) {
        $this->datemodified = $datemodified;
    }

    public function setRecovemail($recovemail) {
        $this->recovemail = $recovemail;
    }
    public function getMyavatar() {
        return $this->myavatar;
    }

    public function setMyavatar($myavatar) {
        $this->myavatar = $myavatar;
    }
    public function getAvatarid() {
        return $this->avatarid;
    }

    public function setAvatarid(\Bundle\AdminBundle\Entity\KidsKulaStudentAvatar $avatarid) {
        $this->avatarid = $avatarid;
    }

    
            function __construct() {
        $this->roles = array('ROLE_STUDENT');
        $this->status = 1;
        $this->salt = md5(rand(1, 8));
        $this->friendsWithMe = new ArrayCollection();
        $this->vetcommConnections = new ArrayCollection();
    }

    function __toString() {
        return $this->email;
    }

// ****************** Friend mapping start  *********************************
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="KidsKulaUsers", inversedBy="KidsKulaUsers")
     * @ORM\JoinTable(name="kidskula_friends",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="friend_id", referencedColumnName="id")
     *   }
     * )
     */
    private $vetcommConnections;

    public function addVetcommConnections(\Bundle\AdminBundle\Entity\KidsKulaUsers $vetcommConnections) {

        if (!$this->vetcommConnections->contains($vetcommConnections)) {
            $this->vetcommConnections->add($vetcommConnections);
        }

        return $this;
    }

    public function removeVetcommConnections(\Bundle\AdminBundle\Entity\KidsKulaUsers $vetcommConnections) {
        $this->vetcommConnections->removeElement($vetcommConnections);
    }

    public function getVetcommConnections() {
        return $this->vetcommConnections;
    }

    /**
     * @ORM\ManyToMany(targetEntity="KidsKulaUsers", mappedBy="vetcommConnections")
     * */
    private $friendsWithMe;
    
    
    public function getFriendsWithMe() {
  
    return $this->friendsWithMe;
    }

// ****************** Friend mapping end  *********************************
}
