<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * KidsKulaClubMember
 *
 * @ORM\Table(name="kidskula_club_member")
 * @ORM\Entity
 * 
 */
 
class KidsKulaClubMember
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
     * @var \Bundle\AdminBundle\Entity\KidsKulaClub
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaClub")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="clubId", referencedColumnName="id", unique=true)
     * })
     */
    private $clubId;
	
	
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;
    
    
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
        $this->date = new \DateTime();
		$this->status = 1;
        //$this->receivedate = new \DateTime();		
    }


    /**
     * Get id
     *
     * @return integer 
     */
    
    public function getId() {
        return $this->id;
    }

    public function getStudentId() {
        return $this->studentId;
    }

    public function getClubId() {
        return $this->clubId;
    }

    public function getDate() {
        return $this->date;
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

    public function setClubId(\Bundle\AdminBundle\Entity\KidsKulaClub $clubId) {
        $this->clubId = $clubId;
    }

    public function setDate(\DateTime $date) {
        $this->date = $date;
    }

    public function setStatus($status) {
        $this->status = $status;
    }



    
}
