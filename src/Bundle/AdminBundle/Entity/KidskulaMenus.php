<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaMenus
 *
 * @ORM\Table(name="kidskula_menus", indexes={@ORM\Index(name="fk_kidskula_menus_kidskula_site_blocks1_idx", columns={"kidskula_site_blocks_id"}), @ORM\Index(name="fk_kidskula_menus_kidskula_modules1_idx", columns={"kidskula_modules_modules_id"})})
 * @ORM\Entity
 */
class KidskulaMenus
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
     * @var string
     *
     * @ORM\Column(name="routes", type="string", length=45, nullable=true)
     */
    private $routes;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordering", type="integer", nullable=true)
     */
    private $ordering;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaModules
     *
     * @ORM\OneToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaModules")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kidskula_modules_modules_id", referencedColumnName="modules_id", unique=true)
     * })
     */
    private $kidskulaModulesModules;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaSiteBlocks
     *
     * @ORM\OneToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaSiteBlocks")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kidskula_site_blocks_id", referencedColumnName="id", unique=true)
     * })
     */
    private $kidskulaSiteBlocks;



    /**
     * Set id
     *
     * @param integer $id
     * @return KidskulaMenus
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
     * Set routes
     *
     * @param string $routes
     * @return KidskulaMenus
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;

        return $this;
    }

    /**
     * Get routes
     *
     * @return string 
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Set ordering
     *
     * @param integer $ordering
     * @return KidskulaMenus
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * Get ordering
     *
     * @return integer 
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return KidskulaMenus
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
     * Set created
     *
     * @param \DateTime $created
     * @return KidskulaMenus
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
     * Set kidskulaModulesModules
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaModules $kidskulaModulesModules
     * @return KidskulaMenus
     */
    public function setKidskulaModulesModules(\Bundle\AdminBundle\Entity\KidskulaModules $kidskulaModulesModules = null)
    {
        $this->kidskulaModulesModules = $kidskulaModulesModules;

        return $this;
    }

    /**
     * Get kidskulaModulesModules
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaModules 
     */
    public function getKidskulaModulesModules()
    {
        return $this->kidskulaModulesModules;
    }

    /**
     * Set kidskulaSiteBlocks
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaSiteBlocks $kidskulaSiteBlocks
     * @return KidskulaMenus
     */
    public function setKidskulaSiteBlocks(\Bundle\AdminBundle\Entity\KidskulaSiteBlocks $kidskulaSiteBlocks = null)
    {
        $this->kidskulaSiteBlocks = $kidskulaSiteBlocks;

        return $this;
    }

    /**
     * Get kidskulaSiteBlocks
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaSiteBlocks 
     */
    public function getKidskulaSiteBlocks()
    {
        return $this->kidskulaSiteBlocks;
    }
}
