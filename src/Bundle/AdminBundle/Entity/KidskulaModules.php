<?php

namespace Bundle\AdminBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaModules
 *
 * @ORM\Table(name="kidskula_modules")
 * @ORM\Entity
 */
class KidskulaModules
{
    /**
     * @var integer
     *
     * @ORM\Column(name="modules_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="modules_language", type="string", length=255, nullable=true)
     */
    private $modulesLanguage;

    /**
     * @var string
     *
     * @ORM\Column(name="modules_title", type="string", length=255, nullable=true)
     */
    private $modulesTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="modules_description", type="text", nullable=true)
     */
    private $modulesDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="modules_ordering", type="integer", nullable=true)
     */
    private $modulesOrdering;

    /**
     * @var string
     *
     * @ORM\Column(name="modules_position", type="string", length=45, nullable=true)
     */
    private $modulesPosition;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modules_publish_date", type="datetime", nullable=true)
     */
    private $modulesPublishDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modules_modified_date", type="datetime", nullable=true)
     */
    private $modulesModifiedDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="modules_status", type="boolean", nullable=true)
     */
    private $modulesStatus;

    /**
     * @var boolean
     *
     * @ORM\Column(name="modules_access", type="boolean", nullable=true)
     */
    private $modulesAccess;



    /**
     * Get modulesId
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set modulesLanguage
     *
     * @param string $modulesLanguage
     * @return KidskulaModules
     */
    public function setModulesLanguage($modulesLanguage)
    {
        $this->modulesLanguage = $modulesLanguage;

        return $this;
    }

    /**
     * Get modulesLanguage
     *
     * @return string 
     */
    public function getModulesLanguage()
    {
        return $this->modulesLanguage;
    }

    /**
     * Set modulesTitle
     *
     * @param string $modulesTitle
     * @return KidskulaModules
     */
    public function setModulesTitle($modulesTitle)
    {
        $this->modulesTitle = $modulesTitle;

        return $this;
    }

    /**
     * Get modulesTitle
     *
     * @return string 
     */
    public function getModulesTitle()
    {
        return $this->modulesTitle;
    }

    /**
     * Set modulesDescription
     *
     * @param string $modulesDescription
     * @return KidskulaModules
     */
    public function setModulesDescription($modulesDescription)
    {
        $this->modulesDescription = $modulesDescription;

        return $this;
    }

    /**
     * Get modulesDescription
     *
     * @return string 
     */
    public function getModulesDescription()
    {
        return $this->modulesDescription;
    }

    /**
     * Set modulesOrdering
     *
     * @param integer $modulesOrdering
     * @return KidskulaModules
     */
    public function setModulesOrdering($modulesOrdering)
    {
        $this->modulesOrdering = $modulesOrdering;

        return $this;
    }

    /**
     * Get modulesOrdering
     *
     * @return integer 
     */
    public function getModulesOrdering()
    {
        return $this->modulesOrdering;
    }

    /**
     * Set modulesPosition
     *
     * @param string $modulesPosition
     * @return KidskulaModules
     */
    public function setModulesPosition($modulesPosition)
    {
        $this->modulesPosition = $modulesPosition;

        return $this;
    }

    /**
     * Get modulesPosition
     *
     * @return string 
     */
    public function getModulesPosition()
    {
        return $this->modulesPosition;
    }

    /**
     * Set modulesPublishDate
     *
     * @param \DateTime $modulesPublishDate
     * @return KidskulaModules
     */
    public function setModulesPublishDate($modulesPublishDate)
    {
        $this->modulesPublishDate = $modulesPublishDate;

        return $this;
    }

    /**
     * Get modulesPublishDate
     *
     * @return \DateTime 
     */
    public function getModulesPublishDate()
    {
        return $this->modulesPublishDate;
    }

    /**
     * Set modulesModifiedDate
     *
     * @param \DateTime $modulesModifiedDate
     * @return KidskulaModules
     */
    public function setModulesModifiedDate($modulesModifiedDate)
    {
        $this->modulesModifiedDate = $modulesModifiedDate;

        return $this;
    }

    /**
     * Get modulesModifiedDate
     *
     * @return \DateTime 
     */
    public function getModulesModifiedDate()
    {
        return $this->modulesModifiedDate;
    }

    /**
     * Set modulesStatus
     *
     * @param boolean $modulesStatus
     * @return KidskulaModules
     */
    public function setModulesStatus($modulesStatus)
    {
        $this->modulesStatus = $modulesStatus;

        return $this;
    }

    /**
     * Get modulesStatus
     *
     * @return boolean 
     */
    public function getModulesStatus()
    {
        return $this->modulesStatus;
    }

    /**
     * Set modulesAccess
     *
     * @param boolean $modulesAccess
     * @return KidskulaModules
     */
    public function setModulesAccess($modulesAccess)
    {
        $this->modulesAccess = $modulesAccess;

        return $this;
    }

    /**
     * Get modulesAccess
     *
     * @return boolean 
     */
    public function getModulesAccess()
    {
        return $this->modulesAccess;
    }
}
