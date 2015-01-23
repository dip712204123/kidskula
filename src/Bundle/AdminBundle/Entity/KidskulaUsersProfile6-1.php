<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile; /*for image resize and upload*/
use Gregwar\Image\Image; /*for image resize and upload*/

/**
 * KidskulaUsersProfile
 *
 * @ORM\Table(name="kidskula_users_profile", indexes={@ORM\Index(name="fk_kidskula_users_profile_kidskula_users_idx", columns={"kidskula_users_user_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class KidskulaUsersProfile
{
    /**
     * @var integer
     *
     * @ORM\Column(name="profile_id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $profileId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="profile_status", type="boolean", nullable=true)
     */
    private $profileStatus;

    /**
     * @var boolean
     *
     * @ORM\Column(name="profile_relationship_status", type="boolean", nullable=true)
     */
    private $profileRelationshipStatus;

    /**
     * @var boolean
     *
     * @ORM\Column(name="profile_relationship_dependency", type="boolean", nullable=true)
     */
    private $profileRelationshipDependency;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_msg", type="string", length=255, nullable=true)
     */
    private $profileMsg;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_about_me", type="text", nullable=true)
     */
    private $profileAboutMe;
	
	/**************** for file upload start *******************/
    /**
     * @var string
     *
     * @ORM\Column(name="profile_profile_picture", type="string", length=255, nullable=true)
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
	/**************** for file upload end *******************/
	
    /**
     * @var string
     *
     * @ORM\Column(name="profile_website", type="string", length=255, nullable=true)
     */
    private $profileWebsite;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_facebook", type="string", length=45, nullable=true)
     */
    private $profileFacebook;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_twitter", type="string", length=45, nullable=true)
     */
    private $profileTwitter;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_google_plus", type="string", length=45, nullable=true)
     */
    private $profileGooglePlus;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_youtube", type="string", length=45, nullable=true)
     */
    private $profileYoutube;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_linkedin", type="string", length=45, nullable=true)
     */
    private $profileLinkedin;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_cropped_image", type="string", length=255, nullable=true)
     */
    private $profileCroppedImage;
	
	/**
     * @var string
     *
     * @ORM\Column(name="profile_cropped_image_size", type="string", length=255, nullable=true)
     */
    private $profileCroppedImageSize;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="profile_date_created", type="datetime", nullable=true)
     */
    private $profileDateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="profile_date_modified", type="datetime", nullable=true)
     */
    private $profileDateModified;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_dob", type="date", nullable=true)
     */	 
	 
    private $profileDob;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_additional_info", type="text", nullable=true)
     */
    private $profileAdditionalInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_video_resume", type="text", nullable=true)
     */
    private $profileVideoResume;

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
     * @var string
     *
     * @ORM\Column(name="visible_to_whom", type="text", nullable=true)
     */
    private $visible_to_whom;
   
    /**
     * @var string
     *
     * @ORM\Column(name="networkUpdates", type="string", nullable=true)
     */
    private $networkUpdates;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="NotifictionsShow", type="boolean", nullable=true)
     */
    private $NotifictionsShow;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="tradeVirtualGifts", type="boolean", nullable=true)
     */
    private $tradeVirtualGifts;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="sendMessages", type="boolean", nullable=true)
     */
    private $sendMessages;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isChat", type="boolean", nullable=true)
     */
    private $isChat;
    

    /**
     * Set profileId
     *
     * @param integer $profileId
     * @return KidskulaUsersProfile
     */
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;

        return $this;
    }

    /**
     * Get profileId
     *
     * @return integer 
     */
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * Set profileStatus
     *
     * @param boolean $profileStatus
     * @return KidskulaUsersProfile
     */
    public function setProfileStatus($profileStatus)
    {
        $this->profileStatus = $profileStatus;

        return $this;
    }

    /**
     * Get profileStatus
     *
     * @return boolean 
     */
    public function getProfileStatus()
    {
        return $this->profileStatus;
    }

    /**
     * Set profileRelationshipStatus
     *
     * @param boolean $profileRelationshipStatus
     * @return KidskulaUsersProfile
     */
    public function setProfileRelationshipStatus($profileRelationshipStatus)
    {
        $this->profileRelationshipStatus = $profileRelationshipStatus;

        return $this;
    }

    /**
     * Get profileRelationshipStatus
     *
     * @return boolean 
     */
    public function getProfileRelationshipStatus()
    {
        return $this->profileRelationshipStatus;
    }

    /**
     * Set profileRelationshipDependency
     *
     * @param boolean $profileRelationshipDependency
     * @return KidskulaUsersProfile
     */
    public function setProfileRelationshipDependency($profileRelationshipDependency)
    {
        $this->profileRelationshipDependency = $profileRelationshipDependency;

        return $this;
    }

    /**
     * Get profileRelationshipDependency
     *
     * @return boolean 
     */
    public function getProfileRelationshipDependency()
    {
        return $this->profileRelationshipDependency;
    }

    /**
     * Set profileMsg
     *
     * @param string $profileMsg
     * @return KidskulaUsersProfile
     */
    public function setProfileMsg($profileMsg)
    {
        $this->profileMsg = $profileMsg;

        return $this;
    }

    /**
     * Get profileMsg
     *
     * @return string 
     */
    public function getProfileMsg()
    {
        return $this->profileMsg;
    }

    /**
     * Set profileAboutMe
     *
     * @param string $profileAboutMe
     * @return KidskulaUsersProfile
     */
    public function setProfileAboutMe($profileAboutMe)
    {
        $this->profileAboutMe = $profileAboutMe;

        return $this;
    }

    /**
     * Get profileAboutMe
     *
     * @return string 
     */
    public function getProfileAboutMe()
    {
        return $this->profileAboutMe;
    }

  

    /**
     * Set profileWebsite
     *
     * @param string $profileWebsite
     * @return KidskulaUsersProfile
     */
    public function setProfileWebsite($profileWebsite)
    {
        $this->profileWebsite = $profileWebsite;

        return $this;
    }

    /**
     * Get profileWebsite
     *
     * @return string 
     */
    public function getProfileWebsite()
    {
        return $this->profileWebsite;
    }

    /**
     * Set profileFacebook
     *
     * @param string $profileFacebook
     * @return KidskulaUsersProfile
     */
    public function setProfileFacebook($profileFacebook)
    {
        $this->profileFacebook = $profileFacebook;

        return $this;
    }

    /**
     * Get profileFacebook
     *
     * @return string 
     */
    public function getProfileFacebook()
    {
        return $this->profileFacebook;
    }

    /**
     * Set profileTwitter
     *
     * @param string $profileTwitter
     * @return KidskulaUsersProfile
     */
    public function setProfileTwitter($profileTwitter)
    {
        $this->profileTwitter = $profileTwitter;

        return $this;
    }

    /**
     * Get profileTwitter
     *
     * @return string 
     */
    public function getProfileTwitter()
    {
        return $this->profileTwitter;
    }

    /**
     * Set profileGooglePlus
     *
     * @param string $profileGooglePlus
     * @return KidskulaUsersProfile
     */
    public function setProfileGooglePlus($profileGooglePlus)
    {
        $this->profileGooglePlus = $profileGooglePlus;

        return $this;
    }

    /**
     * Get profileGooglePlus
     *
     * @return string 
     */
    public function getProfileGooglePlus()
    {
        return $this->profileGooglePlus;
    }

    /**
     * Set profileYoutube
     *
     * @param string $profileYoutube
     * @return KidskulaUsersProfile
     */
    public function setProfileYoutube($profileYoutube)
    {
        $this->profileYoutube = $profileYoutube;

        return $this;
    }

    /**
     * Get profileYoutube
     *
     * @return string 
     */
    public function getProfileYoutube()
    {
        return $this->profileYoutube;
    }

    /**
     * Set profileLinkedin
     *
     * @param string $profileLinkedin
     * @return KidskulaUsersProfile
     */
    public function setProfileLinkedin($profileLinkedin)
    {
        $this->profileLinkedin = $profileLinkedin;

        return $this;
    }

    /**
     * Get profileLinkedin
     *
     * @return string 
     */
    public function getProfileLinkedin()
    {
        return $this->profileLinkedin;
    }

    /**
     * Set profileCroppedImage
     *
     * @param string $profileCroppedImage
     * @return KidskulaUsersProfile
     */
    public function setProfileCroppedImage($profileCroppedImage)
    {
        $this->profileCroppedImage = $profileCroppedImage;

        return $this;
    }

    /**
     * Get profileCroppedImage
     *
     * @return string 
     */
    public function getProfileCroppedImage()
    {
        return $this->profileCroppedImage;
    }
	
	/**
     * Set profileCroppedImageSize
     *
     * @param string $profileCroppedImageSize
     * @return KidskulaUsersProfile
     */
    public function setProfileCroppedImageSize($profileCroppedImageSize)
    {
        $this->profileCroppedImageSize = $profileCroppedImageSize;

        return $this;
    }

    /**
     * Get profileCroppedImageSize
     *
     * @return string 
     */
    public function getProfileCroppedImageSize()
    {
        return $this->profileCroppedImageSize;
    }

    /**
     * Set profileDateCreated
     *
     * @param \DateTime $profileDateCreated
     * @return KidskulaUsersProfile
     */
    public function setProfileDateCreated($profileDateCreated)
    {
        $this->profileDateCreated = $profileDateCreated;

        return $this;
    }

    /**
     * Get profileDateCreated
     *
     * @return \DateTime 
     */
    public function getProfileDateCreated()
    {
        return $this->profileDateCreated;
    }

    /**
     * Set profileDateModified
     *
     * @param \DateTime $profileDateModified
     * @return KidskulaUsersProfile
     */
    public function setProfileDateModified($profileDateModified)
    {
        $this->profileDateModified = $profileDateModified;

        return $this;
    }

    /**
     * Get profileDateModified
     *
     * @return \DateTime 
     */
    public function getProfileDateModified()
    {
        return $this->profileDateModified;
    }

    
    public function setProfileDob($profileDob)
    {
        $this->profileDob = $profileDob;

        return $this;
    }

    
    public function getProfileDob()
    {
        return $this->profileDob;
    }

    /**
     * Set profileAdditionalInfo
     *
     * @param string $profileAdditionalInfo
     * @return KidskulaUsersProfile
     */
    public function setProfileAdditionalInfo($profileAdditionalInfo)
    {
        $this->profileAdditionalInfo = $profileAdditionalInfo;

        return $this;
    }

    /**
     * Get profileAdditionalInfo
     *
     * @return string 
     */
    public function getProfileAdditionalInfo()
    {
        return $this->profileAdditionalInfo;
    }

    /**
     * Set profileVideoResume
     *
     * @param string $profileVideoResume
     * @return KidskulaUsersProfile
     */
    public function setProfileVideoResume($profileVideoResume)
    {
        $this->profileVideoResume = $profileVideoResume;

        return $this;
    }

    /**
     * Get profileVideoResume
     *
     * @return string 
     */
    public function getProfileVideoResume()
    {
        return $this->profileVideoResume;
    }

    /**
     * Set kidskulaUsersUser
     *
     * @param \Bundle\AdminBundle\Entity\KidskulaUsers $kidskulaUsersUser
     * @return KidskulaUsersProfile
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
    public function getVisibletowhom() {
        return $this->visible_to_whom;
    }

    public function getNetworkUpdates() {
        return $this->networkUpdates;
    }

    public function getNotifictionsShow() {
        return $this->NotifictionsShow;
    }

    public function getTradeVirtualGifts() {
        return $this->tradeVirtualGifts;
    }

    public function getSendMessages() {
        return $this->sendMessages;
    }

    public function getIsChat() {
        return $this->isChat;
    }

    public function setVisibletowhom($visible_to_whom) {
        $this->visible_to_whom = $visible_to_whom;
    }

    public function setNetworkUpdates($networkUpdates) {
        $this->networkUpdates = $networkUpdates;
    }

    public function setNotifictionsShow($NotifictionsShow) {
        $this->NotifictionsShow = $NotifictionsShow;
    }

    public function setTradeVirtualGifts($tradeVirtualGifts) {
        $this->tradeVirtualGifts = $tradeVirtualGifts;
    }

    public function setSendMessages($sendMessages) {
        $this->sendMessages = $sendMessages;
    }

    public function setIsChat($isChat) {
        $this->isChat = $isChat;
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
	
}
