<?php

namespace Bundle\AdminBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="kidskula_default_site_config")
 */
class KidsKulaStaticMenus {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="configure_purpose", type="integer", nullable=false)
     */
    private $configure_purpose;

    /**
     * @var string
     *
     * @ORM\Column(name="configure_title", type="string", length=255, nullable=false)
     */
    private $configuretitle;
     /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     */
    private $meta_title;
    /**
     * @var string
     *
     * @ORM\Column(name="meta_keyword", type="string", length=255, nullable=true)
     */
    private $meta_keyword;
    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string",nullable=true)
     */
    private $meta_description;
    /**
     * @var string
     *
     * @ORM\Column(name="configure_description", type="string", nullable=false)
     */
    private $configuredescription;
    /**
     * @var boolean
     *
     * @ORM\Column(name="configure_status", type="boolean", nullable=false)
     */
    private $configure_status;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="configure_date_created", type="datetime",nullable=true)
     */
    private $configure_date_created;
    
   /**
     * @var \DateTime
     *
     * @ORM\Column(name="configure_date_modified", type="datetime",nullable=true)
     */
    private $configure_date_modified;
    
    
     /**
     * @var integer
     *
     * @ORM\Column(name="kidskula_modules_modules_id", type="integer", nullable=false)
     */
    private $kidskula_modules_modules_id;
    
    
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }
    public function getConfigurePurpose() {
        return $this->configure_purpose;
    }

    public function getConfigureTitle() {
        return $this->configuretitle;
    }

    public function getMetaTitle() {
        return $this->meta_title;
    }

    public function getMetaKeyword() {
        return $this->meta_keyword;
    }

    public function getMetaDescription() {
        return $this->meta_description;
    }

    public function getConfigureDescription() {
        return $this->configuredescription;
    }

    public function getConfigureStatus() {
        return $this->configure_status;
    }

    public function getKidskulaModulesModulesId() {
       return $this->kidskula_modules_modules_id;
    }

    

    
    public function getConfigureDateCreated() {
        return $this->configure_date_created;
    }

    public function setConfigurePurpose($configure_purpose) {
        $this->configure_purpose = $configure_purpose;
    }

    public function setConfigureTitle($configuretitle) {
        $this->configure_title = $configuretitle;
    }

    public function setMetaTitle($meta_title) {
        $this->meta_title = $meta_title;
    }

    public function setMetaKeyword($meta_keyword) {
        $this->meta_keyword = $meta_keyword;
    }

    public function setMetaDescription($meta_description) {
        $this->meta_description = $meta_description;
    }

    public function setConfigureDescription($configuredescription) {
        $this->configure_description = $cconfiguredescription;
    }

    public function setConfigureStatus($configure_status) {
        $this->configure_status = $configure_status;
    }

    public function getConfigureDateModified() {
        return $this->configure_date_modified;
    }

    public function setConfigureDateModified(\DateTime $configure_date_modified) {
        $this->configure_date_modified = $configure_date_modified;
    }

    
    public function setConfigureDateCreated(\DateTime $configure_date_created) {
        $this->configure_date_created = $configure_date_created;
    }
    
    public function setKidskulaModulesModulesId($kidskula_modules_modules_id) {
        $this->kidskula_modules_modules_id = $kidskula_modules_modules_id;
    }
    function __toString() {
        return $this->configure_title;
    }


}
