<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile; /*for image resize and upload*/
use Gregwar\Image\Image; /*for image resize and upload*/
/**
 * KidskulaStudentCollection
 *
 * @ORM\Table(name="kidskula_collection")
 * @ORM\Entity
 * @UniqueEntity(fields="collectionTitle", message="Sorry, this name is already occupied.")
 */
 
class KidsKulaStudentCollection
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
     *   @ORM\JoinColumn(name="createdby", referencedColumnName="id", unique=true)
     * })
     */
    private $createdby;
    /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaCollectionCategory
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaCollectionCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoryId", referencedColumnName="id", unique=true)
     * })
     */
    private $categoryId;
    /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaCollectionCategory
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaCollectionCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subcatID", referencedColumnName="id", unique=true)
     * })
     */
    private $subcatID;
    /**
     * @var string
     *
     * @ORM\Column(name="collectionTitle", type="string", length=255, nullable=true)
     */
    private $collectionTitle;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="point", type="integer", nullable=true)
     */
    private $point;
    

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $path;
    /**
     * @Assert\File(
     *     maxSizeMessage = "Profile image must be less than 5mb.",
     *     maxSize = "5000k",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Profile image format must be of types JPG, GIF,jpeg."
     * )
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


    public function getId()
    {
        return $this->id;
    }

    public function setCollectionTitle($collectionTitle)
    {
        $this->collectionTitle = $collectionTitle;
        return $this;
    }

    public function getCollectionTitle()
    {
        return $this->collectionTitle;
    }


    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function getCategoryId() {
        return $this->categoryId;
    }

    public function setCategoryId(\Bundle\AdminBundle\Entity\KidsKulaCollectionCategory $categoryId) {
        $this->categoryId = $categoryId;
    }
    public function getSubcatID() {
        return $this->subcatID;
    }

    public function setSubcatID(\Bundle\AdminBundle\Entity\KidsKulaCollectionCategory $subcatID) {
        $this->subcatID = $subcatID;
    }
        /**************** for file upload start *******************/
    #############Image Upload#############
    
    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function setTemp($temp) {
        $this->temp = $temp;
        return $this;
    }

	public function getPath() {
        return $this->path;
    }

    public function getTemp() {
        return $this->temp;
    }
    public function getPoint() {
        return $this->point;
    }

    public function setPoint($point) {
        $this->point = $point;
    }
    
    
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
        $obj = is_object($file);

        // check if we have an old image path
        if (isset($this->path) && $obj == true) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } elseif (isset($this->path)) {
            $this->file = $file;
        } else {
            $this->path = 'initial';
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

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        //return __DIR__ . '/../../../../web/' . $this->getUploadDir();
		return __DIR__ .$this->getRootDir(). $this->getUploadDir();
    }
	
	public function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
       // return 'upload/profilepicture';
	   return $this->getUploadImagePath(). $this->getProfileImagePath();		
    }
	
	/************** upload image path start ***************/
	private $rootDir;
	
	public function setRootDir($rootDir) {
        $this->rootDir = $rootDir;
        return $this;
    }
	public function getRootDir() {
		 return $this->rootDir;
	}
	
	private $uploadImagePath;	
	
	public function setUploadImagePath($uploadImagePath) {
        $this->uploadImagePath = $uploadImagePath;
        return $this;
    }
	public function getUploadImagePath() {
		 return $this->uploadImagePath;
	}
	
	private $profileImagePath;	
	
	public function setProfileImagePath($profileImagePath) {
        $this->profileImagePath = $profileImagePath;
        return $this;
    }
	public function getProfileImagePath() {
		 return $this->profileImagePath;
	}
	
	private $profileResizeImagePath;	
	
	public function setProfileResizeImagePath($profileResizeImagePath) {
        $this->profileResizeImagePath = $profileResizeImagePath;
        return $this;
    }
	public function getProfileResizeImagePath() {
		 return $this->profileResizeImagePath;
	}
	
	private $profileCropImagePath;	
	
	public function setProfileCropImagePath($profileCropImagePath) {
        $this->profileCropImagePath = $profileCropImagePath;
        return $this;
    }
	public function getProfileCropImagePath() {
		 return $this->profileCropImagePath;
	}
	/************** upload image path end ***************/    

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
            
            $path=$this->getAbsolutePath();
            $absoluteurl=$this->getUploadRootDir();
            $imagename=$this->getPath();
           // Image::open($path)->forceResize(384,512 ,583)->save($absoluteurl.'/resizedimages/'.$imagename);
			Image::open($path)->forceResize(384,512 ,583)->save($absoluteurl.$this->getProfileResizeImagePath().$imagename);
			
			//Image::open($path)->crop(384,512 ,24,40)->save($absoluteurl.'/resizedimages/'.$imagename);

            // check if we have an old image
            if (isset($this->temp)) {
                // delete the old image
                /*@unlink($this->getUploadRootDir() . '/' . $this->temp);
                @unlink($this->getUploadRootDir() . '/resizedimages/' . $this->temp); 
				@unlink($this->getUploadRootDir() . '/cropedimages/' . $this->temp);*/
				@unlink($this->getUploadRootDir() .  $this->temp);
                @unlink($this->getUploadRootDir() . $this->getProfileResizeImagePath() . $this->temp); 
				@unlink($this->getUploadRootDir() . $this->getProfileCropImagePath() . $this->temp);
				
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
        //return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
		 return null === $this->path ? null : $this->getUploadRootDir() . $this->path;
    }	
	
	/**************** for file upload end *******************/
	
	public function cropUpload($image_name) {  
	    
            $path=$this->getAbsolutePath();
            $absoluteurl=$this->getUploadRootDir();
		    $imagename=$image_name['image_name'];
			$x_axix = $image_name['x'];
			$y_axix = $image_name['y'];
			$width = $image_name['w'];
			$height = $image_name['h'];
            //Image::open($path)->crop(384,512 ,24,40)->save($absoluteurl.'/cropedimages/'.$imagename);	
            
			//Image::open($absoluteurl.'/resizedimages/'.$imagename)->crop($x_axix,$y_axix,$width,$height)->save($absoluteurl.'/cropedimages/'.$imagename);
			Image::open($absoluteurl. '/' .$this->getProfileResizeImagePath().$imagename)->crop($x_axix,$y_axix,$width,$height)->save($absoluteurl. '/' .$this->getProfileCropImagePath().$imagename);
            $this->file = null;
    }
    
    public function getCreatedby() {
        return $this->createdby;
    }

    public function setCreatedby(\Bundle\AdminBundle\Entity\KidsKulaUsers $createdby) {
        $this->createdby = $createdby;
    }
   function __toString() {
        return $this->id;
    }

}
