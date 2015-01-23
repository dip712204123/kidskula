<?php

namespace Bundle\AdminBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Kidskula contactus
 *
 * @ORM\Table(name="kidskula_contactus")
 * @ORM\Entity
 * 
 */
class Contactus {

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
     * @ORM\Column(name="senderemail", type="string", length=255, nullable=false)
     */
    private $senderemail;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;
    
     /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     */
    private $firstname;
    
    
      /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     */
    private $lastname;
    
    /**
     * @var string
     *
     * @ORM\Column(name="registered_as", type="string", length=255, nullable=false)
     */
    private $registeredas;
    
    /**
     * @var string
     *
     * @ORM\Column(name="question_regarding", type="string", length=255, nullable=false)
     */
    private $questionregarding;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;
	
	/**
     * @var \Bundle\AdminBundle\Entity\KidsKulaUsers
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sendby", referencedColumnName="id")
     * })
     */
	 private $sendby;
	 
	 /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaContactQuestion
     *
     * @ORM\OneToOne(targetEntity="Bundle\AdminBundle\Entity\KidsKulaContactQuestion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="questionid", referencedColumnName="id", nullable=true)
     * })
     */
	 
    private $questionid;
		
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="viewed", type="boolean", nullable=false)
     */
    private $viewed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;
    
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;
    
     /**
     * @var boolean
     *
     * @ORM\Column(name="contact_me_bymail", type="boolean", nullable=false)
     */
    private $contactmebymail;
    
    
    function __construct() {
        $this->viewed = false;
        $this->date=new \DateTime();
    }

    public function getId() {
        return $this->id;
    }

    public function getSenderemail() {
        return $this->senderemail;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getComment() {
        return $this->comment;
    }
	
	public function getSendby() {
        return $this->sendby;
    }
	
	public function getQuestionid() {
        return $this->questionid;
    }

    public function getViewed() {
        return $this->viewed;
    }

    public function getDate() {
        return $this->date;
    }
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

        public function setId($id) {
        $this->id = $id;
    }

    public function setSenderemail($senderemail) {
        $this->senderemail = $senderemail;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }
	
	public function setSendby(\Bundle\AdminBundle\Entity\KidsKulaUsers $sendby) {
        $this->sendby = $sendby;
    }
	
	public function setQuestionid( \Bundle\AdminBundle\Entity\KidsKulaContactQuestion $questionid ) {
        $this->questionid = $questionid;
    }
	
    public function setViewed($viewed) {
        $this->viewed = $viewed;
    }

    public function setDate(\DateTime $date) {
        $this->date = $date;
    }
    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getRegisteredas() {
        return $this->registeredas;
    }

    public function getQuestionregarding() {
        return $this->questionregarding;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function setRegisteredas($registeredas) {
        $this->registeredas = $registeredas;
    }

    public function setQuestionregarding($questionregarding) {
        $this->questionregarding = $questionregarding;
    }

    public function getContactmebymail() {
        return $this->contactmebymail;
    }

    public function setContactmebymail($contactmebymail) {
        $this->contactmebymail = $contactmebymail;
    }
    
}
