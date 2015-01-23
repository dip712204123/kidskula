<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile; /*for image resize and upload*/
use Gregwar\Image\Image; /*for image resize and upload*/
/**
 * KidsKulaClub
 *
 * @ORM\Table(name="kidskulla_messaging")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields="title", message="Sorry, this name is already occupied.")
 */
 
class KidskullaMessaging
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
     *   @ORM\JoinColumn(name="to_user", referencedColumnName="id", unique=true)
     * })
     */
    private $touser;
    
    /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaUsers
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="from_user", referencedColumnName="id", unique=true)
     * })
     */
    private $fromuser;
    
    /**
     * @var string
     *
     * @ORM\Column(name="seen_by_user", type="string", nullable=true)
     */
    private $seenbyuser;
	
    /**
     * @var string
     *
     * @ORM\Column(name="seen_by_admin", type="string", nullable=true)
     */
    private $seenbyadmin;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime",nullable=true)
     */
    private $createddate;
    
   /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_date", type="datetime",nullable=true)
     */
    private $modifiedDate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="texttoshow", type="text", nullable=true)
     */
    private $texttoshow;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    private $status;
    
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parentid;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="sender_status", type="string", nullable=true)
     */
    private $senderstatus;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="receiver_status", type="string", nullable=true)
     */
    private $receiverstatus;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kidskulaUsersUser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = 1;
        $this->createddate = new \DateTime();
        $this->seenbyuser = 2;
        $this->seenbyadmin = 1;
        $this->senderstatus = 1;
    }


    function getId() {
        return $this->id;
    }

    function getTouser() {
        return $this->touser;
    }

    function getFromuser() {
        return $this->fromuser;
    }

    function getSeenbyuser() {
        return $this->seenbyuser;
    }

    function getSeenbyadmin() {
        return $this->seenbyadmin;
    }

    function getCreateddate() {
        return $this->createddate;
    }

    function getModifiedDate() {
        return $this->modifiedDate;
    }

    function getTexttoshow() {
        return $this->texttoshow;
    }

    function getStatus() {
        return $this->status;
    }

    function getParentid() {
        return $this->parentid;
    }

    function getSenderstatus() {
        return $this->senderstatus;
    }

    function getReceiverstatus() {
        return $this->receiverstatus;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTouser(\Bundle\AdminBundle\Entity\KidsKulaUsers $touser) {
        $this->touser = $touser;
    }

    function setFromuser(\Bundle\AdminBundle\Entity\KidsKulaUsers $fromuser) {
        $this->fromuser = $fromuser;
    }

    function setSeenbyuser($seenbyuser) {
        $this->seenbyuser = $seenbyuser;
    }

    function setSeenbyadmin($seenbyadmin) {
        $this->seenbyadmin = $seenbyadmin;
    }

    function setCreateddate(\DateTime $createddate) {
        $this->createddate = $createddate;
    }

    function setModifiedDate(\DateTime $modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }

    function setTexttoshow($texttoshow) {
        $this->texttoshow = $texttoshow;
    }

    function setStatus($status) {
        $this->status = $status;
    }
    
    function setParentid($parentid) {
        $this->parentid = $parentid;
    }

    function setSenderstatus($senderstatus) {
        $this->senderstatus = $senderstatus;
    }

    function setReceiverstatus($receiverstatus) {
        $this->receiverstatus = $receiverstatus;
    }

    

   
   function __toString() {
        return $this->id;
        //return $this->title;
    }

}
