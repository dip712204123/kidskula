<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaDefaultSiteConfig
 *
 * @ORM\Table(name="kidskula_default_site_config", indexes={@ORM\Index(name="fk_kidskula_default_site_config_kidskula_modules1_idx", columns={"kidskula_modules_modules_id"})})
 * @ORM\Entity
 */
class KidskulaDefaultSiteConfig
{
    /**
     * @var integer
     *
     * @ORM\Column(name="configure_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $configureId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="configure_purpose", type="boolean", nullable=true)
     */
    private $configurePurpose;

    /**
     * @var string
     *
     * @ORM\Column(name="configure_title", type="string", length=255, nullable=true)
     */
    private $configureTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="configure_description", type="text", nullable=true)
     */
    private $configureDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="configure_status", type="boolean", nullable=true)
     */
    private $configureStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="configure_date_created", type="datetime", nullable=true)
     */
    private $configureDateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="configure_date_modified", type="datetime", nullable=true)
     */
    private $configureDateModified;

    /**
     * @var string
     *
     * @ORM\Column(name="configure_imagepath", type="string", length=255, nullable=true)
     */
    private $configureImagepath;

    /**
     * @var string
     *
     * @ORM\Column(name="configure_image_name", type="string", length=255, nullable=true)
     */
    private $configureImageName;

    /**
     * @var string
     *
     * @ORM\Column(name="configure_file_type", type="string", length=255, nullable=true)
     */
    private $configureFileType;

    /**
     * @var string
     *
     * @ORM\Column(name="configure_file_extn", type="string", length=45, nullable=true)
     */
    private $configureFileExtn;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keyword", type="string", length=255, nullable=true)
     */
    private $metaKeyword;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="text", nullable=true)
     */
    private $metaDescription;

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
     * Set configureId
     *
     * @param integer $configureId
     * @return KidskulaDefaultSiteConfig
     */
    public function setConfigureId($configureId)
    {
        $this->configureId = $configureId;

        return $this;
    }

    /**
     * Get configureId
     *
     * @return integer 
     */
    public function getConfigureId()
    {
        return $this->configureId;
    }

    /**
     * Set configurePurpose
     *
     * @param boolean $configurePurpose
     * @return KidskulaDefaultSiteConfig
     */
    public function setConfigurePurpose($configurePurpose)
    {
        $this->configurePurpose = $configurePurpose;

        return $this;
    }

    /**
     * Get configurePurpose
     *
     * @return boolean 
     */
    public function getConfigurePurpose()
    {
        return $this->configurePurpose;
    }

    /**
     * Set configureTitle
     *
     * @param string $configureTitle
     * @return KidskulaDefaultSiteConfig
     */
    public function setConfigureTitle($configureTitle)
    {
        $this->configureTitle = $configureTitle;

        return $this;
    }

    /**
     * Get configureTitle
     *
     * @return string 
     */
    public function getConfigureTitle()
    {
        return $this->configureTitle;
    }

    /**
     * Set configureDescription
     *
     * @param string $configureDescription
     * @return KidskulaDefaultSiteConfig
     */
    public function setConfigureDescription($configureDescription)
    {
        $this->configureDescription = $configureDescription;

        return $this;
    }

    /**
     * Get configureDescription
     *
     * @return string 
     */
    public function getConfigureDescription()
    {
        return $this->configureDescription;
    }

    /**
     * Set configureStatus
     *
     * @param boolean $configureStatus
     * @return KidskulaDefaultSiteConfig
     */
    public function setConfigureStatus($configureStatus)
    {
        $this->configureStatus = $configureStatus;

        return $this;
    }

    /**
     * Get configureStatus
     *
     * @return boolean 
     */
    public function getConfigureStatus()
    {
        return $this->configureStatus;
    }

    /**
     * Set configureDateCreated
     *
     * @param \DateTime $configureDateCreated
     * @return KidskulaDefaultSiteConfig
     */
    public function setConfigureDateCreated($configureDateCreated)
    {
        $this->configureDateCreated = $configureDateCreated;

        return $this;
    }

    /**
     * Get configureDateCreated
     *
     * @return \DateTime 
     */
    public function getConfigureDateCreated()
    {
        return $this->configureDateCreated;
    }

    /**
     * Set configureDateModified
     *
     * @param \DateTime $configureDateModified
     * @return KidskulaDefaultSiteConfig
     */
    public function setConfigureDateModified($configureDateModified)
    {
        $this->configureDateModified = $configureDateModified;

        return $this;
    }

    /**
     * Get configureDateModified
     *
     * @return \DateTime 
     */
    public function getConfigureDateModified()
    {
        return $this->configureDateModified;
    }

    /**
     * Set configureImagepath
     *
     * @param string $configureImagepath
     * @return KidskulaDefaultSiteConfig
     */
    public function setConfigureImagepath($configureImagepath)
    {
        $this->configureImagepath = $configureImagepath;

        return $this;
    }

    /**
     * Get configureImagepath
     *
     * @return string 
     */
    public function getConfigureImagepath()
    {
        return $this->configureImagepath;
    }

    /**
     * Set configureImageName
     *
     * @param string $configureImageName
     * @return KidskulaDefaultSiteConfig
     */
    public function setConfigureImageName($configureImageName)
    {
        $this->configureImageName = $configureImageName;

        return $this;
    }

    /**
     * Get configureImageName
     *
     * @return string 
     */
    public function getConfigureImageName()
    {
        return $this->configureImageName;
    }

    /**
     * Set configureFileType
     *
     * @param string $configureFileType
     * @return KidskulaDefaultSiteConfig
     */
    public function setConfigureFileType($configureFileType)
    {
        $this->configureFileType = $configureFileType;

        return $this;
    }

    /**
     * Get configureFileType
     *
     * @return string 
     */
    public function getConfigureFileType()
    {
        return $this->configureFileType;
    }

    /**
     * Set configureFileExtn
     *
     * @param string $configureFileExtn
     * @return KidskulaDefaultSiteConfig
     */
    public function setConfigureFileExtn($configureFileExtn)
    {
        $this->configureFileExtn = $configureFileExtn;

        return $this;
    }

    /**
     * Get configureFileExtn
     *
     * @return string 
     */
    public function getConfigureFileExtn()
    {
        return $this->configureFileExtn;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     * @return KidskulaDefaultSiteConfig
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string 
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaKeyword
     *
     * @param string $metaKeyword
     * @return KidskulaDefaultSiteConfig
     */
    public function setMetaKeyword($metaKeyword)
    {
        $this->metaKeyword = $metaKeyword;

        return $this;
    }

    /**
     * Get metaKeyword
     *
     * @return string 
     */
    public function getMetaKeyword()
    {
        return $this->metaKeyword;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return KidskulaDefaultSiteConfig
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string 
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set kidskulaModulesModules
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaModules $kidskulaModulesModules
     * @return KidskulaDefaultSiteConfig
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
}
