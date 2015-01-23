<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaGameRecommendation
 *
 * @ORM\Table(name="kidskula_game_recommendation", indexes={@ORM\Index(name="fk_kidskula_game_recommendation_kidskula_gmaes1_idx", columns={"kidskula_gmaes_id"}), @ORM\Index(name="fk_kidskula_user_id_idx", columns={"recommended_by"}), @ORM\Index(name="fk_kidskula_recommended_to_idx", columns={"recommended_to"})})
 * @ORM\Entity
 */
class KidskulaGameRecommendation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_accepted", type="boolean", nullable=true)
     */
    private $isAccepted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="recommend_date", type="datetime", nullable=true)
     */
    private $recommendDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="accepted_date", type="datetime", nullable=true)
     */
    private $acceptedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="sender_comment", type="text", nullable=true)
     */
    private $senderComment;

    /**
     * @var string
     *
     * @ORM\Column(name="receiver_comment", type="text", nullable=true)
     */
    private $receiverComment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaGames
     *
     * @ORM\OneToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaGames")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kidskula_gmaes_id", referencedColumnName="id", unique=true)
     * })
     */
    private $kidskulaGmaes;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaUsers
     *
     * @ORM\ManyToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recommended_by", referencedColumnName="id")
     * })
     */
    private $recommendedBy;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaUsers
     *
     * @ORM\ManyToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recommended_to", referencedColumnName="id")
     * })
     */
    private $recommendedTo;



    /**
     * Set id
     *
     * @param integer $id
     * @return KidskulaGameRecommendation
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set isAccepted
     *
     * @param boolean $isAccepted
     * @return KidskulaGameRecommendation
     */
    public function setIsAccepted($isAccepted)
    {
        $this->isAccepted = $isAccepted;

        return $this;
    }

    /**
     * Get isAccepted
     *
     * @return boolean 
     */
    public function getIsAccepted()
    {
        return $this->isAccepted;
    }

    /**
     * Set recommendDate
     *
     * @param \DateTime $recommendDate
     * @return KidskulaGameRecommendation
     */
    public function setRecommendDate($recommendDate)
    {
        $this->recommendDate = $recommendDate;

        return $this;
    }

    /**
     * Get recommendDate
     *
     * @return \DateTime 
     */
    public function getRecommendDate()
    {
        return $this->recommendDate;
    }

    /**
     * Set acceptedDate
     *
     * @param \DateTime $acceptedDate
     * @return KidskulaGameRecommendation
     */
    public function setAcceptedDate($acceptedDate)
    {
        $this->acceptedDate = $acceptedDate;

        return $this;
    }

    /**
     * Get acceptedDate
     *
     * @return \DateTime 
     */
    public function getAcceptedDate()
    {
        return $this->acceptedDate;
    }

    /**
     * Set senderComment
     *
     * @param string $senderComment
     * @return KidskulaGameRecommendation
     */
    public function setSenderComment($senderComment)
    {
        $this->senderComment = $senderComment;

        return $this;
    }

    /**
     * Get senderComment
     *
     * @return string 
     */
    public function getSenderComment()
    {
        return $this->senderComment;
    }

    /**
     * Set receiverComment
     *
     * @param string $receiverComment
     * @return KidskulaGameRecommendation
     */
    public function setReceiverComment($receiverComment)
    {
        $this->receiverComment = $receiverComment;

        return $this;
    }

    /**
     * Get receiverComment
     *
     * @return string 
     */
    public function getReceiverComment()
    {
        return $this->receiverComment;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return KidskulaGameRecommendation
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
     * Set kidskulaGmaes
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaGames $kidskulaGmaes
     * @return KidskulaGameRecommendation
     */
    public function setKidskulaGmaes(\Bundle\AdminBundle\Entity\KidskulaGames $kidskulaGmaes = null)
    {
        $this->kidskulaGmaes = $kidskulaGmaes;

        return $this;
    }

    /**
     * Get kidskulaGmaes
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaGames 
     */
    public function getKidskulaGmaes()
    {
        return $this->kidskulaGmaes;
    }

    /**
     * Set recommendedBy
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $recommendedBy
     * @return KidskulaGameRecommendation
     */
    public function setRecommendedBy(\Bundle\AdminBundle\Entity\KidskulaUsers $recommendedBy = null)
    {
        $this->recommendedBy = $recommendedBy;

        return $this;
    }

    /**
     * Get recommendedBy
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaUsers 
     */
    public function getRecommendedBy()
    {
        return $this->recommendedBy;
    }

    /**
     * Set recommendedTo
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $recommendedTo
     * @return KidskulaGameRecommendation
     */
    public function setRecommendedTo(\Bundle\AdminBundle\Entity\KidskulaUsers $recommendedTo = null)
    {
        $this->recommendedTo = $recommendedTo;

        return $this;
    }

    /**
     * Get recommendedTo
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaUsers 
     */
    public function getRecommendedTo()
    {
        return $this->recommendedTo;
    }
}
