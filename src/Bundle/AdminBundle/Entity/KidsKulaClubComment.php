<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * KidsKulaClubComment
 *
 * @ORM\Table(name="kidskula_club_comment")
 * @ORM\Entity
 * 
 */
 
class KidsKulaClubComment
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
     * @var \Bundle\AdminBundle\Entity\KidsKulaUsers
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)
     * })
     */
    private $userid;
    
    /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaClubComment
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaClubComment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id", unique=true)
     * })
     */
    private $parentId;
	
	/**
     * @var \Bundle\AdminBundle\Entity\KidsKulaClubArticle
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaClubArticle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="event_id", referencedColumnName="id", unique=true)
     * })
     */
    private $eventid;
	
    /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaClub
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaClub")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="club_id", referencedColumnName="id", unique=true)
     * })
     */
    private $clubId;
	
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $datecreated;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=true)
     */
    private $datemodified;
    
    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", nullable=false)
     */
    private $comment;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    private $status;
    
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kidskulaUsersUser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datecreated = new \DateTime();
		$this->status = 1;
        //$this->receivedate = new \DateTime();		
    }


    /**
     * Get id
     *
     * @return integer 
     */
    
    public function getId() {
        return $this->id;
    }

    public function getUserid() {
        return $this->userid;
    }

    public function getParentid() {
        return $this->parentId;
    }

    public function getEventid() {
        return $this->eventid;
    }

    public function getDatecreated() {
        return $this->datecreated;
    }

    public function getDatemodified() {
        return $this->datemodified;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUserid(\Bundle\AdminBundle\Entity\KidsKulaUsers $userid) {
        $this->userid = $userid;
    }

    public function setParentid(\Bundle\AdminBundle\Entity\KidsKulaClubComment $parentId) {
        $this->parentId = $parentId;
    }

    public function setEventid(\Bundle\AdminBundle\Entity\KidsKulaClubArticle $eventid) {
        $this->eventid = $eventid;
    }

    public function setDatecreated(\DateTime $datecreated) {
        $this->datecreated = $datecreated;
    }

    public function setDatemodified(\DateTime $datemodified) {
        $this->datemodified = $datemodified;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
    function getClubId() {
        return $this->clubId;
    }
    
    function setClubId(\Bundle\AdminBundle\Entity\KidsKulaClub $clubId) {
        $this->clubId = $clubId;
    }

    
}
