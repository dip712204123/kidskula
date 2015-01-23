<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile; /*for image resize and upload*/
use Gregwar\Image\Image; /*for image resize and upload*/
/**
 * KidsKulaClub
 *
 * @ORM\Table(name="kidskula_clubs")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields="title", message="Sorry, this name is already occupied.")
 */
 
class KidsKulaClub
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
     * @var \Bundle\AdminBundle\Entity\KidsKulaUsers
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ownerId", referencedColumnName="id", unique=true)
     * })
     */
    private $ownerId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true,unique=true)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;
	
	/**
     * @var string
     *
     * @ORM\Column(name="video", type="string", nullable=true)
     */
    private $video;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createDate", type="datetime",nullable=true)
     */
    private $createDate;
    
   /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedDate", type="datetime",nullable=true)
     */
    private $modifiedDate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title_image", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var string $file
     * @Assert\File( 
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},mimeTypesMessage = "Please upload a valid Image")
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $file;

    private $temp;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    private $status;	
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kidskulaUsersUser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = 1;
    }


    function getId() {
        return $this->id;
    }

    function getOwnerId() {
        return $this->ownerId;
    }

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getVideo() {
        return $this->video;
    }

    function getCreateDate() {
        return $this->createDate;
    }

    function getModifiedDate() {
        return $this->modifiedDate;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setOwnerId(\Bundle\AdminBundle\Entity\KidsKulaUsers $ownerId) {
        $this->ownerId = $ownerId;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setVideo($video) {
        $this->video = $video;
    }

    function setCreateDate(\DateTime $createDate) {
        $this->createDate = $createDate;
    }

    function setModifiedDate(\DateTime $modifiedDate) {
        $this->modifiedDate = $modifiedDate;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    /**************** for file upload start *******************/
    #############Image Upload#############
    
    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
     public function getTemp() {
        return $this->temp;
    }

   
    public function setTemp($temp) {
        $this->temp = $temp;
        return $this;
    }
    
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
        $obj = is_object($file);
        //print_r($file); die;
        // check if we have an old image path
        if (isset($this->path) && $obj == true) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = 'null';
        } elseif (isset($this->path)) {
            $this->file = $file;
        } else {
            $this->path = '';
        }
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getFile() {
        return $this->file;
    }

        
	/************** upload image path start ***************/
	
	protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'upload/clubimages';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        $file = $this->getFile();
         $obj = is_object($file);

        if (null !== $this->getFile() && $obj == true) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {

        $file = $this->getFile();
        $obj = is_object($file);

        if (null != $this->getFile() && $obj == true) {
// if there is an error when moving the file, an exception will
            // be automatically thrown by move(). This will properly prevent
            // the entity from being persisted to the database on error
            $this->getFile()->move($this->getUploadRootDir(), $this->path);

            // check if we have an old image
            if (isset($this->temp)) {
                // delete the old image
                @unlink($this->getUploadRootDir() . '/' . $this->temp);
                // clear the temp image path
                $this->temp = null;
            }
            $this->file = null;
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if ($file = $this->getAbsolutePath()) {
            @unlink($file);
        }
    }

    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    private $imageurl;

    public function getImageurl() {

        if (empty($this->imageurl) && !empty($this->path)) {
            $this->imageurl = $this->getUploadDir() . '/' . $this->path;
        }

        return $this->imageurl;
    }

    public function setImageurl($imageurl) {
        $this->imageurl = $this->getUploadRootDir() . $imageurl;
        return $this;
    }

	/************** upload image path end ***************/    

   
   function __toString() {
        //return $this->id;
        return $this->title;
    }

}
