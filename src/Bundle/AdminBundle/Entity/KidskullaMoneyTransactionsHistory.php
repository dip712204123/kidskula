<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskullaMoneyTransactionsHistory
 *
 * @ORM\Table(name="kidskulla_money_transactions_history", indexes={@ORM\Index(name="fk_money_transaction_parent_id_idx", columns={"parent_id"}), @ORM\Index(name="fk_money_transaction_childrent_id_idx", columns={"children_id"})})
 * @ORM\Entity
 */
class KidskullaMoneyTransactionsHistory
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
     * @var string
     *
     * @ORM\Column(name="amount_transferres", type="decimal", precision=20, scale=2, nullable=true)
     */
    private $amountTransferres;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateof_transaction", type="datetime", nullable=true)
     */
    private $dateofTransaction;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaUsers
     *
     * @ORM\ManyToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="children_id", referencedColumnName="id")
     * })
     */
    private $children;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaUsers
     *
     * @ORM\ManyToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;



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
     * Set amountTransferres
     *
     * @param string $amountTransferres
     * @return KidskullaMoneyTransactionsHistory
     */
    public function setAmountTransferres($amountTransferres)
    {
        $this->amountTransferres = $amountTransferres;

        return $this;
    }

    /**
     * Get amountTransferres
     *
     * @return string 
     */
    public function getAmountTransferres()
    {
        return $this->amountTransferres;
    }

    /**
     * Set dateofTransaction
     *
     * @param \DateTime $dateofTransaction
     * @return KidskullaMoneyTransactionsHistory
     */
    public function setDateofTransaction($dateofTransaction)
    {
        $this->dateofTransaction = $dateofTransaction;

        return $this;
    }

    /**
     * Get dateofTransaction
     *
     * @return \DateTime 
     */
    public function getDateofTransaction()
    {
        return $this->dateofTransaction;
    }

    /**
     * Set children
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $children
     * @return KidskullaMoneyTransactionsHistory
     */
    public function setChildren(\Bundle\AdminBundle\Entity\KidskulaUsers $children = null)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaUsers 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $parent
     * @return KidskullaMoneyTransactionsHistory
     */
    public function setParent(\Bundle\AdminBundle\Entity\KidskulaUsers $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaUsers 
     */
    public function getParent()
    {
        return $this->parent;
    }
}
