<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaLessonCategory
 *
 * @ORM\Table(name="kidskula_lesson_category", indexes={@ORM\Index(name="fk_kidskula_created_by_idx", columns={"created_by"})})
 * @ORM\Entity
 */
class KidskulaLessonCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cat_name", type="string", length=255, nullable=true)
     */
    private $catName;

    /**
     * @var string
     *
     * @ORM\Column(name="cat_description", type="text", nullable=true)
     */
    private $catDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_date", type="datetime", nullable=true)
     */
    private $modifiedDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaUsers
     *
     * @ORM\ManyToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     * })
     */
    private $createdBy;



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
     * Set catName
     *
     * @param string $catName
     * @return KidskulaLessonCategory
     */
    public function setCatName($catName)
    {
        $this->catName = $catName;

        return $this;
    }

    /**
     * Get catName
     *
     * @return string 
     */
    public function getCatName()
    {
        return $this->catName;
    }

    /**
     * Set catDescription
     *
     * @param string $catDescription
     * @return KidskulaLessonCategory
     */
    public function setCatDescription($catDescription)
    {
        $this->catDescription = $catDescription;

        return $this;
    }

    /**
     * Get catDescription
     *
     * @return string 
     */
    public function getCatDescription()
    {
        return $this->catDescription;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return KidskulaLessonCategory
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return KidskulaLessonCategory
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime 
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return KidskulaLessonCategory
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
     * Set createdBy
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $createdBy
     * @return KidskulaLessonCategory
     */
    public function setCreatedBy(\Bundle\AdminBundle\Entity\KidskulaUsers $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Bundle\AdminBundle\Entity\KidskulaUsers 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}
