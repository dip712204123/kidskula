<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaPaymenthistory
 *
 * @ORM\Table(name="kidskula_paymenthistory", indexes={@ORM\Index(name="fk_kidskula_paymenthistory_kidskula_users1_idx", columns={"kidskula_users_user_id"})})
 * @ORM\Entity
 */
class KidskulaPaymenthistory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50, nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="order_id", type="string", length=255, nullable=true)
     */
    private $orderId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="transactionverified", type="boolean", nullable=true)
     */
    private $transactionverified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="verifieddate", type="datetime", nullable=true)
     */
    private $verifieddate;

    /**
     * @var string
     *
     * @ORM\Column(name="payer_firstname", type="string", length=150, nullable=true)
     */
    private $payerFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="payer_lastname", type="string", length=150, nullable=true)
     */
    private $payerLastname;

    /**
     * @var string
     *
     * @ORM\Column(name="payer_email", type="string", length=150, nullable=true)
     */
    private $payerEmail;

    /**
     * @var float
     *
     * @ORM\Column(name="payer_amount", type="float", precision=10, scale=0, nullable=true)
     */
    private $payerAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="payer_itemname", type="string", length=255, nullable=true)
     */
    private $payerItemname;

    /**
     * @var string
     *
     * @ORM\Column(name="payer_tx_token", type="string", length=45, nullable=true)
     */
    private $payerTxToken;

    /**
     * @var string
     *
     * @ORM\Column(name="package_info", type="text", nullable=true)
     */
    private $packageInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="user_info", type="text", nullable=true)
     */
    private $userInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="payinfo", type="text", nullable=false)
     */
    private $payinfo;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaUsers
     *
     * @ORM\OneToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kidskula_users_user_id", referencedColumnName="id", unique=true)
     * })
     */
    private $kidskulaUsersUser;



    /**
     * Set id
     *
     * @param integer $id
     * @return KidskulaPaymenthistory
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
     * Set status
     *
     * @param string $status
     * @return KidskulaPaymenthistory
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
     * Set created
     *
     * @param \DateTime $created
     * @return KidskulaPaymenthistory
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set orderId
     *
     * @param string $orderId
     * @return KidskulaPaymenthistory
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return string 
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set transactionverified
     *
     * @param boolean $transactionverified
     * @return KidskulaPaymenthistory
     */
    public function setTransactionverified($transactionverified)
    {
        $this->transactionverified = $transactionverified;

        return $this;
    }

    /**
     * Get transactionverified
     *
     * @return boolean 
     */
    public function getTransactionverified()
    {
        return $this->transactionverified;
    }

    /**
     * Set verifieddate
     *
     * @param \DateTime $verifieddate
     * @return KidskulaPaymenthistory
     */
    public function setVerifieddate($verifieddate)
    {
        $this->verifieddate = $verifieddate;

        return $this;
    }

    /**
     * Get verifieddate
     *
     * @return \DateTime 
     */
    public function getVerifieddate()
    {
        return $this->verifieddate;
    }

    /**
     * Set payerFirstname
     *
     * @param string $payerFirstname
     * @return KidskulaPaymenthistory
     */
    public function setPayerFirstname($payerFirstname)
    {
        $this->payerFirstname = $payerFirstname;

        return $this;
    }

    /**
     * Get payerFirstname
     *
     * @return string 
     */
    public function getPayerFirstname()
    {
        return $this->payerFirstname;
    }

    /**
     * Set payerLastname
     *
     * @param string $payerLastname
     * @return KidskulaPaymenthistory
     */
    public function setPayerLastname($payerLastname)
    {
        $this->payerLastname = $payerLastname;

        return $this;
    }

    /**
     * Get payerLastname
     *
     * @return string 
     */
    public function getPayerLastname()
    {
        return $this->payerLastname;
    }

    /**
     * Set payerEmail
     *
     * @param string $payerEmail
     * @return KidskulaPaymenthistory
     */
    public function setPayerEmail($payerEmail)
    {
        $this->payerEmail = $payerEmail;

        return $this;
    }

    /**
     * Get payerEmail
     *
     * @return string 
     */
    public function getPayerEmail()
    {
        return $this->payerEmail;
    }

    /**
     * Set payerAmount
     *
     * @param float $payerAmount
     * @return KidskulaPaymenthistory
     */
    public function setPayerAmount($payerAmount)
    {
        $this->payerAmount = $payerAmount;

        return $this;
    }

    /**
     * Get payerAmount
     *
     * @return float 
     */
    public function getPayerAmount()
    {
        return $this->payerAmount;
    }

    /**
     * Set payerItemname
     *
     * @param string $payerItemname
     * @return KidskulaPaymenthistory
     */
    public function setPayerItemname($payerItemname)
    {
        $this->payerItemname = $payerItemname;

        return $this;
    }

    /**
     * Get payerItemname
     *
     * @return string 
     */
    public function getPayerItemname()
    {
        return $this->payerItemname;
    }

    /**
     * Set payerTxToken
     *
     * @param string $payerTxToken
     * @return KidskulaPaymenthistory
     */
    public function setPayerTxToken($payerTxToken)
    {
        $this->payerTxToken = $payerTxToken;

        return $this;
    }

    /**
     * Get payerTxToken
     *
     * @return string 
     */
    public function getPayerTxToken()
    {
        return $this->payerTxToken;
    }

    /**
     * Set packageInfo
     *
     * @param string $packageInfo
     * @return KidskulaPaymenthistory
     */
    public function setPackageInfo($packageInfo)
    {
        $this->packageInfo = $packageInfo;

        return $this;
    }

    /**
     * Get packageInfo
     *
     * @return string 
     */
    public function getPackageInfo()
    {
        return $this->packageInfo;
    }

    /**
     * Set userInfo
     *
     * @param string $userInfo
     * @return KidskulaPaymenthistory
     */
    public function setUserInfo($userInfo)
    {
        $this->userInfo = $userInfo;

        return $this;
    }

    /**
     * Get userInfo
     *
     * @return string 
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    /**
     * Set payinfo
     *
     * @param string $payinfo
     * @return KidskulaPaymenthistory
     */
    public function setPayinfo($payinfo)
    {
        $this->payinfo = $payinfo;

        return $this;
    }

    /**
     * Get payinfo
     *
     * @return string 
     */
    public function getPayinfo()
    {
        return $this->payinfo;
    }

    /**
     * Set kidskulaUsersUser
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $kidskulaUsersUser
     * @return KidskulaPaymenthistory
     */
    public function setKidskulaUsersUser(\Bundle\AdminBundle\Entity\KidskulaUsers $kidskulaUsersUser = null)
    {
        $this->kidskulaUsersUser = $kidskulaUsersUser;

        return $this;
    }

    /**
     * Get kidskulaUsersUser
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaUsers 
     */
    public function getKidskulaUsersUser()
    {
        return $this->kidskulaUsersUser;
    }
}
