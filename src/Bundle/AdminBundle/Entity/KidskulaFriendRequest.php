<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaFriendRequest
 *
 * @ORM\Table(name="kidskula_friend_request", indexes={@ORM\Index(name="fk_kidskula_friend_request_sender_id_idx", columns={"sender_id"})})
 * @ORM\Entity
 */
class KidskulaFriendRequest
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="receiver_id", type="bigint", nullable=true)
     */
    private $receiverId;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="sender_parent_approval", type="string", nullable=true)
     */
    private $senderParentApproval;

    /**
     * @var string
     *
     * @ORM\Column(name="reciever_parent_approval", type="string", nullable=true)
     */
    private $recieverParentApproval;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="send_date", type="datetime", nullable=true)
     */
    private $sendDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reply_date", type="datetime", nullable=true)
     */
    private $replyDate;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaUsers
     *
     * @ORM\ManyToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sender_id", referencedColumnName="id")
     * })
     */
    private $sender;



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
     * Set receiverId
     *
     * @param integer $receiverId
     * @return KidskulaFriendRequest
     */
    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;

        return $this;
    }

    /**
     * Get receiverId
     *
     * @return integer 
     */
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return KidskulaFriendRequest
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
     * Set senderParentApproval
     *
     * @param boolean $senderParentApproval
     * @return KidskulaFriendRequest
     */
    public function setSenderParentApproval($senderParentApproval)
    {
        $this->senderParentApproval = $senderParentApproval;

        return $this;
    }

    /**
     * Get senderParentApproval
     *
     * @return boolean 
     */
    public function getSenderParentApproval()
    {
        return $this->senderParentApproval;
    }

    /**
     * Set recieverParentApproval
     *
     * @param boolean $recieverParentApproval
     * @return KidskulaFriendRequest
     */
    public function setRecieverParentApproval($recieverParentApproval)
    {
        $this->recieverParentApproval = $recieverParentApproval;

        return $this;
    }

    /**
     * Get recieverParentApproval
     *
     * @return boolean 
     */
    public function getRecieverParentApproval()
    {
        return $this->recieverParentApproval;
    }

    /**
     * Set sendDate
     *
     * @param \DateTime $sendDate
     * @return KidskulaFriendRequest
     */
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;

        return $this;
    }

    /**
     * Get sendDate
     *
     * @return \DateTime 
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * Set replyDate
     *
     * @param \DateTime $replyDate
     * @return KidskulaFriendRequest
     */
    public function setReplyDate($replyDate)
    {
        $this->replyDate = $replyDate;

        return $this;
    }

    /**
     * Get replyDate
     *
     * @return \DateTime 
     */
    public function getReplyDate()
    {
        return $this->replyDate;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return KidskulaFriendRequest
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set sender
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $sender
     * @return KidskulaFriendRequest
     */
    public function setSender(\Bundle\AdminBundle\Entity\KidskulaUsers $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaUsers 
     */
    public function getSender()
    {
        return $this->sender;
    }
}
