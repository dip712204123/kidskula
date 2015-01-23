<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * KidsKullaschoolshaskidskulausers
 *
 * @ORM\Table(name="kidskulla_schools_has_kidskula_users")
 * @ORM\Entity
 * 
 */
 
class KidsKullaschoolshaskidskulausers
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
     *   @ORM\JoinColumn(name="kidskula_users_user_id", referencedColumnName="id", unique=true)
     * })
     */
    private $kidskulausersid;
	
    /**
     * @var string
     *
     *   @ORM\Column(name="kidskulla_schools_id",  type="integer")
     */
    private $KidsKullaschoolsid ;
	
	/**
     * @var string
     *
     * @ORM\Column(name="grade_id", type="integer")
     */
    private $gradeId;
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kidskulaUsersUser = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    public function getKidskulausersid() {
        return $this->kidskulausersid;
    }

    public function getKidsKullaschoolsid() {
        return $this->KidsKullaschoolsid ;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setKidskulausersid(\Bundle\AdminBundle\Entity\KidsKulaUsers $kidskulausersid) {
        $this->kidskulausersid = $kidskulausersid;
    }

    /*public function setKidsKullaschoolsid(\Bundle\AdminBundle\Entity\KidsKullaSchools $KidsKullaschoolsid) {
        $this->KidsKullaschoolsid = $KidsKullaschoolsid;
    }*/	
	
	public function setKidsKullaschoolsid($KidsKullaschoolsid ) {
        $this->KidsKullaschoolsid  = $KidsKullaschoolsid ;
		return $this;
    }
	
	
	 public function getGradeId() {
        return $this->gradeId;
    }

    public function setGradeId($gradeId) {
        $this->gradeId = $gradeId;
    }

}
