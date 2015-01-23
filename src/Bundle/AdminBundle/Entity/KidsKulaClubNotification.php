<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidsKulaClubNotification
 *
 * @ORM\Table(name="kidskula_club_notification")
 * @ORM\Entity
 */
class KidsKulaClubNotification
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
     * @var boolean
     *
     * @ORM\Column(name="seen_by_user", type="boolean", nullable=false)
     */
    private $seenByUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_date", type="datetime", nullable=true)
     */
    private $modifiedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="texttoshow", type="string", nullable=true)
     */
    private $texttoshow;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="text", nullable=true)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="reciever_status", type="string", nullable=true)
     */
    private $recieverStatus;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sender_status", type="boolean", nullable=true)
     */
    private $senderStatus;
    
    /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaClub
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaClub")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="clubId", referencedColumnName="id", unique=true)
     * })
     */
    private $clubId;
    
    /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaClubArticle
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaClubArticle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="articleId", referencedColumnName="id", unique=true)
     * })
     */
    private $articleId;
    
    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaUsers
     *
     * @ORM\ManyToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="to_user", referencedColumnName="id")
     * })
     */
    private $toUser;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaUsers
     *
     * @ORM\ManyToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="from_user", referencedColumnName="id")
     * })
     */
    private $fromUser;


	
	public function __construct()
    {
     
        $this->createdDate = new \DateTime();
        $this->seenByUser = 0;
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
     * Set seenByUser
     *
     * @param boolean $seenByUser
     * @return KidskulaNotification
     */
    public function setSeenByUser($seenByUser)
    {
        $this->seenByUser = $seenByUser;

        return $this;
    }

    /**
     * Get seenByUser
     *
     * @return boolean 
     */
    public function getSeenByUser()
    {
        return $this->seenByUser;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return KidskulaNotification
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return KidskulaNotification
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime 
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set texttoshow
     *
     * @param string $texttoshow
     * @return KidskulaNotification
     */
    public function setTexttoshow($texttoshow)
    {
        $this->texttoshow = $texttoshow;

        return $this;
    }

    /**
     * Get texttoshow
     *
     * @return string 
     */
    public function getTexttoshow()
    {
        return $this->texttoshow;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return KidskulaNotification
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set recieverStatus
     *
     * @param boolean $recieverStatus
     * @return KidskulaNotification
     */
    public function setRecieverStatus($recieverStatus)
    {
        $this->recieverStatus = $recieverStatus;

        return $this;
    }

    /**
     * Get recieverStatus
     *
     * @return boolean 
     */
    public function getRecieverStatus()
    {
        return $this->recieverStatus;
    }

    /**
     * Set senderStatus
     *
     * @param boolean $senderStatus
     * @return KidskulaNotification
     */
    public function setSenderStatus($senderStatus)
    {
        $this->senderStatus = $senderStatus;

        return $this;
    }

    /**
     * Get senderStatus
     *
     * @return boolean 
     */
    public function getSenderStatus()
    {
        return $this->senderStatus;
    }
    public function getClubId() {
        return $this->clubId;
    }

    public function getArticleId() {
        return $this->articleId;
    }

    public function setClubId(\Bundle\AdminBundle\Entity\KidsKulaClub $clubId) {
        $this->clubId = $clubId;
    }

    public function setArticleId(\Bundle\AdminBundle\Entity\KidsKulaClubArticle $articleId) {
        $this->articleId = $articleId;
    }

        /**
     * Set toUser
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $toUser
     * @return KidskulaNotification
     */
    public function setToUser(\Bundle\AdminBundle\Entity\KidskulaUsers $toUser = null)
    {
        $this->toUser = $toUser;

        return $this;
    }

    /**
     * Get toUser
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaUsers 
     */
    public function getToUser()
    {
        return $this->toUser;
    }

    /**
     * Set fromUser
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $fromUser
     * @return KidskulaNotification
     */
    public function setFromUser(\Bundle\AdminBundle\Entity\KidskulaUsers $fromUser = null)
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    /**
     * Get fromUser
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaUsers 
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }
}
