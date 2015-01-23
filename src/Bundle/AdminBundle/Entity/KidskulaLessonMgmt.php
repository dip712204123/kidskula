<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaLessonMgmt
 *
 * @ORM\Table(name="kidskula_lesson_mgmt", indexes={@ORM\Index(name="fk_kidskula_owner_id_idx", columns={"owner_id"}), @ORM\Index(name="fk_kidskula_lesson_mgmt_kidskula_lesson_category1_idx", columns={"kidskula_lesson_category_id"})})
 * @ORM\Entity
 */
class KidskulaLessonMgmt
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
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=true)
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="admin_approved_date", type="datetime", nullable=true)
     */
    private $adminApprovedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="admin_reject_date", type="datetime", nullable=true)
     */
    private $adminRejectDate;

    /**
     * @var string
     *
     * @ORM\Column(name="lesson_title", type="string", length=255, nullable=true)
     */
    private $lessonTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="lesson_description", type="text", nullable=true)
     */
    private $lessonDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="file_base_name", type="string", length=255, nullable=true)
     */
    private $fileBaseName;

    /**
     * @var string
     *
     * @ORM\Column(name="file_type", type="string", length=255, nullable=true)
     */
    private $fileType;

    /**
     * @var string
     *
     * @ORM\Column(name="file_extension", type="string", length=255, nullable=true)
     */
    private $fileExtension;

    /**
     * @var boolean
     *
     * @ORM\Column(name="admin_approval", type="boolean", nullable=true)
     */
    private $adminApproval;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaLessonCategory
     *
     * @ORM\OneToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaLessonCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kidskula_lesson_category_id", referencedColumnName="id", unique=true)
     * })
     */
    private $kidskulaLessonCategory;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaUsers
     *
     * @ORM\ManyToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     * })
     */
    private $owner;



    /**
     * Set id
     *
     * @param integer $id
     * @return KidskulaLessonMgmt
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return KidskulaLessonMgmt
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set adminApprovedDate
     *
     * @param \DateTime $adminApprovedDate
     * @return KidskulaLessonMgmt
     */
    public function setAdminApprovedDate($adminApprovedDate)
    {
        $this->adminApprovedDate = $adminApprovedDate;

        return $this;
    }

    /**
     * Get adminApprovedDate
     *
     * @return \DateTime 
     */
    public function getAdminApprovedDate()
    {
        return $this->adminApprovedDate;
    }

    /**
     * Set adminRejectDate
     *
     * @param \DateTime $adminRejectDate
     * @return KidskulaLessonMgmt
     */
    public function setAdminRejectDate($adminRejectDate)
    {
        $this->adminRejectDate = $adminRejectDate;

        return $this;
    }

    /**
     * Get adminRejectDate
     *
     * @return \DateTime 
     */
    public function getAdminRejectDate()
    {
        return $this->adminRejectDate;
    }

    /**
     * Set lessonTitle
     *
     * @param string $lessonTitle
     * @return KidskulaLessonMgmt
     */
    public function setLessonTitle($lessonTitle)
    {
        $this->lessonTitle = $lessonTitle;

        return $this;
    }

    /**
     * Get lessonTitle
     *
     * @return string 
     */
    public function getLessonTitle()
    {
        return $this->lessonTitle;
    }

    /**
     * Set lessonDescription
     *
     * @param string $lessonDescription
     * @return KidskulaLessonMgmt
     */
    public function setLessonDescription($lessonDescription)
    {
        $this->lessonDescription = $lessonDescription;

        return $this;
    }

    /**
     * Get lessonDescription
     *
     * @return string 
     */
    public function getLessonDescription()
    {
        return $this->lessonDescription;
    }

    /**
     * Set fileBaseName
     *
     * @param string $fileBaseName
     * @return KidskulaLessonMgmt
     */
    public function setFileBaseName($fileBaseName)
    {
        $this->fileBaseName = $fileBaseName;

        return $this;
    }

    /**
     * Get fileBaseName
     *
     * @return string 
     */
    public function getFileBaseName()
    {
        return $this->fileBaseName;
    }

    /**
     * Set fileType
     *
     * @param string $fileType
     * @return KidskulaLessonMgmt
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * Get fileType
     *
     * @return string 
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * Set fileExtension
     *
     * @param string $fileExtension
     * @return KidskulaLessonMgmt
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    /**
     * Get fileExtension
     *
     * @return string 
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * Set adminApproval
     *
     * @param boolean $adminApproval
     * @return KidskulaLessonMgmt
     */
    public function setAdminApproval($adminApproval)
    {
        $this->adminApproval = $adminApproval;

        return $this;
    }

    /**
     * Get adminApproval
     *
     * @return boolean 
     */
    public function getAdminApproval()
    {
        return $this->adminApproval;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return KidskulaLessonMgmt
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return KidskulaLessonMgmt
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set kidskulaLessonCategory
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaLessonCategory $kidskulaLessonCategory
     * @return KidskulaLessonMgmt
     */
    public function setKidskulaLessonCategory(\Bundle\AdminBundle\Entity\KidskulaLessonCategory $kidskulaLessonCategory = null)
    {
        $this->kidskulaLessonCategory = $kidskulaLessonCategory;

        return $this;
    }

    /**
     * Get kidskulaLessonCategory
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaLessonCategory 
     */
    public function getKidskulaLessonCategory()
    {
        return $this->kidskulaLessonCategory;
    }

    /**
     * Set owner
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $owner
     * @return KidskulaLessonMgmt
     */
    public function setOwner(\Bundle\AdminBundle\Entity\KidskulaUsers $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaUsers 
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
