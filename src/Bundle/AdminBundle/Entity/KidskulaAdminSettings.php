<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaAdminSettings
 *
 * @ORM\Table(name="kidskula_admin_settings", uniqueConstraints={@ORM\UniqueConstraint(name="config_key_UNIQUE", columns={"config_key"})}, indexes={@ORM\Index(name="fk_kidskula_admin_settings_kidskula_modules1_idx", columns={"kidskula_modules_modules_id"})})
 * @ORM\Entity
 */
class KidskulaAdminSettings
{
    /**
     * @var integer
     *
     * @ORM\Column(name="settings_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $settingsId;

    /**
     * @var string
     *
     * @ORM\Column(name="config_key", type="string", length=255, nullable=false)
     */
    private $configKey;

    /**
     * @var string
     *
     * @ORM\Column(name="config_value", type="text", nullable=true)
     */
    private $configValue;

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
     * Set settingsId
     *
     * @param integer $settingsId
     * @return KidskulaAdminSettings
     */
    public function setSettingsId($settingsId)
    {
        $this->settingsId = $settingsId;

        return $this;
    }

    /**
     * Get settingsId
     *
     * @return integer 
     */
    public function getSettingsId()
    {
        return $this->settingsId;
    }

    /**
     * Set configKey
     *
     * @param string $configKey
     * @return KidskulaAdminSettings
     */
    public function setConfigKey($configKey)
    {
        $this->configKey = $configKey;

        return $this;
    }

    /**
     * Get configKey
     *
     * @return string 
     */
    public function getConfigKey()
    {
        return $this->configKey;
    }

    /**
     * Set configValue
     *
     * @param string $configValue
     * @return KidskulaAdminSettings
     */
    public function setConfigValue($configValue)
    {
        $this->configValue = $configValue;

        return $this;
    }

    /**
     * Get configValue
     *
     * @return string 
     */
    public function getConfigValue()
    {
        return $this->configValue;
    }

    /**
     * Set kidskulaModulesModules
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaModules $kidskulaModulesModules
     * @return KidskulaAdminSettings
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
