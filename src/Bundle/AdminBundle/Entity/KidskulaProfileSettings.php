<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaProfileSettings
 *
 * @ORM\Table(name="kidskula_profile_settings", indexes={@ORM\Index(name="fk_kidskula_profile_settings_kidskula_users1_idx", columns={"kidskula_users_user_id"})})
 * @ORM\Entity
 */
class KidskulaProfileSettings
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
     * @var boolean
     *
     * @ORM\Column(name="visibil_to_whom", type="boolean", nullable=true)
     */
    private $visibilToWhom;

    /**
     * @var string
     *
     * @ORM\Column(name="what_to_show", type="text", nullable=true)
     */
    private $whatToShow;

    /**
     * @var integer
     *
     * @ORM\Column(name="my_children_id", type="bigint", nullable=true)
     */
    private $myChildrenId;

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
     * @return KidskulaProfileSettings
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
     * Set visibilToWhom
     *
     * @param boolean $visibilToWhom
     * @return KidskulaProfileSettings
     */
    public function setVisibilToWhom($visibilToWhom)
    {
        $this->visibilToWhom = $visibilToWhom;

        return $this;
    }

    /**
     * Get visibilToWhom
     *
     * @return boolean 
     */
    public function getVisibilToWhom()
    {
        return $this->visibilToWhom;
    }

    /**
     * Set whatToShow
     *
     * @param string $whatToShow
     * @return KidskulaProfileSettings
     */
    public function setWhatToShow($whatToShow)
    {
        $this->whatToShow = $whatToShow;

        return $this;
    }

    /**
     * Get whatToShow
     *
     * @return string 
     */
    public function getWhatToShow()
    {
        return $this->whatToShow;
    }

    /**
     * Set myChildrenId
     *
     * @param integer $myChildrenId
     * @return KidskulaProfileSettings
     */
    public function setMyChildrenId($myChildrenId)
    {
        $this->myChildrenId = $myChildrenId;

        return $this;
    }

    /**
     * Get myChildrenId
     *
     * @return integer 
     */
    public function getMyChildrenId()
    {
        return $this->myChildrenId;
    }

    /**
     * Set kidskulaUsersUser
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $kidskulaUsersUser
     * @return KidskulaProfileSettings
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
