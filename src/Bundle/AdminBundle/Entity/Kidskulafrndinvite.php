<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Kidskulafrndinvite
 *
 * @ORM\Table(name="kidskula_frnd_invite")
 * @ORM\Entity
 * @UniqueEntity(fields="receiveremail", message="Sorry, invitation has alraedy been sent in this email.")
 */
 
class Kidskulafrndinvite
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
     *   @ORM\JoinColumn(name="sender", referencedColumnName="id", unique=true)
     * })
     */
    private $sender;
	
	
	/**
     * @var string
     *
     *   @ORM\Column(name="receiver_email", length=255, type="string")
     */
    private $receiveremail ;
	
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="send_date", type="datetime", nullable=true)
     */
    private $senddate;
    
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="accept_date", type="datetime", nullable=true)
     */
    private $acceptdate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    private $status;
    
    
    /**
     * @var string
     *
     *   @ORM\Column(name="invite_key", type="string",nullable=false)
     */
    private $invitekey ;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kidskulaUsersUser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->senddate = new \DateTime();
        //$this->acceptdate = new \DateTime();		
    }


    /**
     * Get id
     *
     * @return integer 
     */
    
    public function getId() {
        return $this->id;
    }

    public function getSender() {
        return $this->sender;
    }

    public function getReceiveremail() {
        return $this->receiveremail;
    }

    public function getSenddate() {
        return $this->senddate;
    }

    public function getAcceptdate() {
        return $this->acceptdate;
    }
    
    public function getStatus(){ 
        return $this->status; 
    }
    
    public function getInvitekey(){ 
        return $this->invitekey; 
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setSender(\Bundle\AdminBundle\Entity\KidsKulaUsers $sender) {
        $this->sender = $sender;
    }

    public function setReceiveremail($receiveremail) {
        $this->receiveremail = $receiveremail;
    }

    public function setSenddate(\DateTime $senddate) {
        $this->senddate = $senddate;
    }

    public function setAcceptdate(\DateTime $acceptdate) {
        $this->acceptdate = $acceptdate;
    }    
   
	public function setStatus($status){ 
	   $this->status=$status; 
    }
    
    public function setInvitekey($invitekey){ 
	   $this->invitekey=$invitekey; 
    }

}
