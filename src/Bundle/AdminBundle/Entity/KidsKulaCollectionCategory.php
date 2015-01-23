<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile; /*for image resize and upload*/
use Gregwar\Image\Image; /*for image resize and upload*/
/**
 * KidsKulaCollectionCategory
 *
 * @ORM\Table(name="kidskula_collection_category")
 * @ORM\Entity
 * @UniqueEntity(fields="categoryName", message="Sorry, this name is already occupied.")
 */
 
class KidsKulaCollectionCategory
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
     * @var integer
     *
     * @ORM\Column(name="parent", type="integer", nullable=false)
     */
    private $parent;
    
    /**
     * @var string
     *
     * @ORM\Column(name="categoryName", type="string", length=255, nullable=true)
     */
    private $categoryName;

   
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    private $status;
    
    /**
     * @var string
     *
     * @ORM\Column(name="points_activity", type="string", nullable=true)
     */
    private $pointsactivity;
    
    /**
     * Constructor
     */
    public function __construct()
    {
//        $this->kidskulaUsersUser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = 1;
    }


    public function getId() {
        return $this->id;
    }
    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }

        public function getCategoryName() {
        return $this->categoryName;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCategoryName($categoryName) {
        $this->categoryName = $categoryName;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    public function getPointsactivity() {
        return $this->pointsactivity;
    }

    public function setPointsactivity($pointsactivity) {
        $this->pointsactivity = $pointsactivity;
    }




}
