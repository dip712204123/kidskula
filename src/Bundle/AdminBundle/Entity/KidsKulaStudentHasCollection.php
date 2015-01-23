<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile; /*for image resize and upload*/
use Gregwar\Image\Image; /*for image resize and upload*/
/**
 * KidsKulaStudentHasCollection
 *
 * @ORM\Table(name="kidskula_student_has_collection")
 * @ORM\Entity
 * 
 */
 
class KidsKulaStudentHasCollection
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
     *   @ORM\JoinColumn(name="studentId", referencedColumnName="id", unique=true)
     * })
     */
    private $studentId;
    /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaStudentCollection
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaStudentCollection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="collectionId", referencedColumnName="id", unique=true)
     * })
     */
    private $collectionId;
    /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaUsers
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tradewith", referencedColumnName="id", unique=true)
     * })
     */
    private $tradewith;
    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="point", type="integer", nullable=true)
     */
    private $point;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="getdate", type="datetime", nullable=true)
     */
    private $getdate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sharedate", type="datetime", nullable=true)
     */
    private $sharedate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    private $status;
    
    /**
     * @var string
     *
     *   @ORM\Column(name="invite_key",type="string", nullable=true)
     */
    private $invitekey ;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="collection_point", type="integer", nullable=true)
     */
    private $collectionPoint;
     
    /**
     * @var string
     *
     * @ORM\Column(name="getcollection", type="string", nullable=true)
     */
    private $getcollection;
    /**
     * Constructor
     */
    public function __construct()
    {
//        $this->kidskulaUsersUser = new \Doctrine\Common\Collections\ArrayCollection();
       
        $this->getdate = new \DateTime();
        $this->status = 1;
    }
    public function getId() {
        return $this->id;
    }

    public function getStudentId() {
        return $this->studentId;
    }

    public function getCollectionId() {
        return $this->collectionId;
    }

    public function getTradewith() {
        return $this->tradewith;
    }

    public function getPoint() {
        return $this->point;
    }

    public function getGetdate() {
        return $this->getdate;
    }

    public function getSharedate() {
        return $this->sharedate;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setStudentId(\Bundle\AdminBundle\Entity\KidsKulaUsers $studentId) {
        $this->studentId = $studentId;
    }

    public function setCollectionId(\Bundle\AdminBundle\Entity\KidsKulaStudentCollection $collectionId) {
        $this->collectionId = $collectionId;
    }

    public function setTradewith(\Bundle\AdminBundle\Entity\KidsKulaUsers $tradewith) {
        $this->tradewith = $tradewith;
    }

    public function setPoint($point) {
        $this->point = $point;
    }

    public function setGetdate(\DateTime $getdate) {
        $this->getdate = $getdate;
    }

    public function setSharedate(\DateTime $sharedate) {
        $this->sharedate = $sharedate;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getInvitekey() {
        return $this->invitekey;
    }

    public function setInvitekey($invitekey) {
        $this->invitekey = $invitekey;
    }

    public function getGetcollection() {
        return $this->getcollection;
    }

    public function setGetcollection($getcollection) {
        $this->getcollection = $getcollection;
    }
    
    public function getCollectionPoint() {
        return $this->collectionPoint;
    }

    public function setCollectionPoint($collectionPoint) {
        $this->collectionPoint = $collectionPoint;
    }
    


}
