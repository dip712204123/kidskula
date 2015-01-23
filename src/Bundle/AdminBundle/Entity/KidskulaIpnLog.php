<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaIpnLog
 *
 * @ORM\Table(name="kidskula_ipn_log")
 * @ORM\Entity
 */
class KidskulaIpnLog
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
     * @ORM\Column(name="listener_name", type="string", length=3, nullable=true)
     */
    private $listenerName;

    /**
     * @var string
     *
     * @ORM\Column(name="transaction_type", type="string", length=16, nullable=true)
     */
    private $transactionType;

    /**
     * @var string
     *
     * @ORM\Column(name="transaction_id", type="string", length=19, nullable=true)
     */
    private $transactionId;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=16, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=512, nullable=true)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="ipn_data_hash", type="string", length=32, nullable=true)
     */
    private $ipnDataHash;

    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="text", nullable=true)
     */
    private $detail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="payemt_history_id", type="bigint", nullable=true)
     */
    private $payemtHistoryId;



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
     * Set listenerName
     *
     * @param string $listenerName
     * @return KidskulaIpnLog
     */
    public function setListenerName($listenerName)
    {
        $this->listenerName = $listenerName;

        return $this;
    }

    /**
     * Get listenerName
     *
     * @return string 
     */
    public function getListenerName()
    {
        return $this->listenerName;
    }

    /**
     * Set transactionType
     *
     * @param string $transactionType
     * @return KidskulaIpnLog
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * Get transactionType
     *
     * @return string 
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * Set transactionId
     *
     * @param string $transactionId
     * @return KidskulaIpnLog
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * Get transactionId
     *
     * @return string 
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return KidskulaIpnLog
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return KidskulaIpnLog
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set ipnDataHash
     *
     * @param string $ipnDataHash
     * @return KidskulaIpnLog
     */
    public function setIpnDataHash($ipnDataHash)
    {
        $this->ipnDataHash = $ipnDataHash;

        return $this;
    }

    /**
     * Get ipnDataHash
     *
     * @return string 
     */
    public function getIpnDataHash()
    {
        return $this->ipnDataHash;
    }

    /**
     * Set detail
     *
     * @param string $detail
     * @return KidskulaIpnLog
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return string 
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return KidskulaIpnLog
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return KidskulaIpnLog
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set payemtHistoryId
     *
     * @param integer $payemtHistoryId
     * @return KidskulaIpnLog
     */
    public function setPayemtHistoryId($payemtHistoryId)
    {
        $this->payemtHistoryId = $payemtHistoryId;

        return $this;
    }

    /**
     * Get payemtHistoryId
     *
     * @return integer 
     */
    public function getPayemtHistoryId()
    {
        return $this->payemtHistoryId;
    }
}
