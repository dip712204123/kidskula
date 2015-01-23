<?php
//Done by sourav@18_12_2014
namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * KidsKulaStudentPoint
 *
 * @ORM\Table(name="kidskula_student_point")
 * @ORM\Entity
 * 
 */
 
class KidsKulaStudentPoint
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
     * @var integer
     *
     * @ORM\Column(name="point", type="integer", nullable=true)
     */
    private $point;
    /**
     * @var integer
     *
     * @ORM\Column(name="totalcollection", type="integer", nullable=true)
     */
    private $totalcollection;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_addedDate", type="datetime", nullable=true)
     */
    private $lastaddedDate;
   
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
    //$this->kidskulaUsersUser = new \Doctrine\Common\Collections\ArrayCollection();
       
        $this->lastaddedDate = new \DateTime();
        $this->status = 1;
    }
    public function getId() {
        return $this->id;
    }

    public function getStudentId() {
        return $this->studentId;
    }

    public function getPoint() {
        return $this->point;
    }

    public function getTotalcollection() {
        return $this->totalcollection;
    }

    public function getLastaddedDate() {
        return $this->lastaddedDate;
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

    public function setPoint($point) {
        $this->point = $point;
    }

    public function setTotalcollection($totalcollection) {
        $this->totalcollection = $totalcollection;
    }

    public function setLastaddedDate(\DateTime $lastaddedDate) {
        $this->lastaddedDate = $lastaddedDate;
    }

    public function setStatus($status) {
        $this->status = $status;
    }




}
