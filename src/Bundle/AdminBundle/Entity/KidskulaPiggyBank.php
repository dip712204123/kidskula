<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaPiggyBank
 *
 * @ORM\Table(name="kidskula_piggy_bank", indexes={@ORM\Index(name="fk_kidskula_piggy_bank_kidskula_users1_idx", columns={"kidskula_users_user_id"})})
 * @ORM\Entity
 */
class KidskulaPiggyBank
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
     * @ORM\Column(name="amount", type="decimal", precision=20, scale=2, nullable=true)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="last_transaction_date", type="string", length=45, nullable=true)
     */
    private $lastTransactionDate;

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
     * @return KidskulaPiggyBank
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
     * Set amount
     *
     * @param string $amount
     * @return KidskulaPiggyBank
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set lastTransactionDate
     *
     * @param string $lastTransactionDate
     * @return KidskulaPiggyBank
     */
    public function setLastTransactionDate($lastTransactionDate)
    {
        $this->lastTransactionDate = $lastTransactionDate;

        return $this;
    }

    /**
     * Get lastTransactionDate
     *
     * @return string 
     */
    public function getLastTransactionDate()
    {
        return $this->lastTransactionDate;
    }

    /**
     * Set kidskulaUsersUser
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $kidskulaUsersUser
     * @return KidskulaPiggyBank
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
