<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * KidsKulaCollectionTradeHistory
 *
 * @ORM\Table(name="kidskula_collection_trade_history")
 * @ORM\Entity
 * 
 */
 
class KidsKulaCollectionTradeHistory
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
     *   @ORM\JoinColumn(name="senderId", referencedColumnName="id", unique=true)
     * })
     */
    private $senderId;
	
	/**
     * @var \Bundle\AdminBundle\Entity\KidsKulaUsers
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="receiverId", referencedColumnName="id", unique=true)
     * })
     */
    private $receiverId;
	
	/**
     * @var \Bundle\AdminBundle\Entity\KidsKulaStudentCollection
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaStudentCollection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sender_collectionid", referencedColumnName="id", unique=true)
     * })
     */
    private $sendercollectionid;
	
	/**
     * @var \Bundle\AdminBundle\Entity\KidsKulaStudentCollection
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaStudentCollection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="receiver_collectionid", referencedColumnName="id", unique=true)
     * })
     */
    private $receivercollectionid;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="sender_col_point", type="integer", nullable=true)
     */
    private $sendercolpoint;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="receiver_col_point", type="integer", nullable=true)
     */
    private $receivercolpoint;
	
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="send_date", type="datetime", nullable=true)
     */
    private $senddate;
    
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="receive_date", type="datetime", nullable=true)
     */
    private $receivedate;
    
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
        $this->senddate = new \DateTime();
        //$this->receivedate = new \DateTime();		
    }


    /**
     * Get id
     *
     * @return integer 
     */
    function getId() {
        return $this->id;
    }

    function getSenderId() {
        return $this->senderId;
    }

    function getReceiverId() {
        return $this->receiverId;
    }

    function getSendercollectionid() {
        return $this->sendercollectionid;
    }

    function getReceivercollectionid() {
        return $this->receivercollectionid;
    }

    function getSendercolpoint() {
        return $this->sendercolpoint;
    }

    function getReceivercolpoint() {
        return $this->receivercolpoint;
    }

    function getSenddate() {
        return $this->senddate;
    }

    function getReceivedate() {
        return $this->receivedate;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setSenderId(\Bundle\AdminBundle\Entity\KidsKulaUsers $senderId) {
        $this->senderId = $senderId;
    }

    function setReceiverId(\Bundle\AdminBundle\Entity\KidsKulaUsers $receiverId) {
        $this->receiverId = $receiverId;
    }

    function setSendercollectionid(\Bundle\AdminBundle\Entity\KidsKulaStudentCollection $sendercollectionid) {
        $this->sendercollectionid = $sendercollectionid;
    }

    function setReceivercollectionid(\Bundle\AdminBundle\Entity\KidsKulaStudentCollection $receivercollectionid) {
        $this->receivercollectionid = $receivercollectionid;
    }

    function setSendercolpoint($sendercolpoint) {
        $this->sendercolpoint = $sendercolpoint;
    }

    function setReceivercolpoint($receivercolpoint) {
        $this->receivercolpoint = $receivercolpoint;
    }

    function setSenddate(\DateTime $senddate) {
        $this->senddate = $senddate;
    }

    function setReceivedate(\DateTime $receivedate) {
        $this->receivedate = $receivedate;
    }

    function setStatus($status) {
        $this->status = $status;
    }


    
}
