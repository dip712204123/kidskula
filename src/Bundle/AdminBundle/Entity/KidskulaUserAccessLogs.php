<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaUserAccessLogs
 *
 * @ORM\Table(name="kidskula_user_access_logs", indexes={@ORM\Index(name="fk_vetcomm_user_access_logs_vetcomm_users1_idx", columns={"users_id"})})
 * @ORM\Entity
 */
class KidskulaUserAccessLogs
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
     * @var integer
     *
     * @ORM\Column(name="users_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $usersId;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=200, nullable=false)
     */
    private $ipAddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="in_datetime", type="datetime", nullable=false)
     */
    private $inDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="out_datetime", type="datetime", nullable=true)
     */
    private $outDatetime;



    /**
     * Set id
     *
     * @param integer $id
     * @return KidskulaUserAccessLogs
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
     * Set usersId
     *
     * @param integer $usersId
     * @return KidskulaUserAccessLogs
     */
    public function setUsersId($usersId)
    {
        $this->usersId = $usersId;

        return $this;
    }

    /**
     * Get usersId
     *
     * @return integer 
     */
    public function getUsersId()
    {
        return $this->usersId;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     * @return KidskulaUserAccessLogs
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string 
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set inDatetime
     *
     * @param \DateTime $inDatetime
     * @return KidskulaUserAccessLogs
     */
    public function setInDatetime($inDatetime)
    {
        $this->inDatetime = $inDatetime;

        return $this;
    }

    /**
     * Get inDatetime
     *
     * @return \DateTime 
     */
    public function getInDatetime()
    {
        return $this->inDatetime;
    }

    /**
     * Set outDatetime
     *
     * @param \DateTime $outDatetime
     * @return KidskulaUserAccessLogs
     */
    public function setOutDatetime($outDatetime)
    {
        $this->outDatetime = $outDatetime;

        return $this;
    }

    /**
     * Get outDatetime
     *
     * @return \DateTime 
     */
    public function getOutDatetime()
    {
        return $this->outDatetime;
    }
}
