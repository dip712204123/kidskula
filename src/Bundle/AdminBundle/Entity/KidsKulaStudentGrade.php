<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * KidskulaStudentGrade
 *
 * @ORM\Table(name="kidskula_student_grade")
 * @ORM\Entity
 * @UniqueEntity(fields="grade", message="Sorry, this grade is already in use.")
 */
class KidsKulaStudentGrade
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
     * @ORM\Column(name="grade", type="string", length=255, nullable=false,unique=true)
     */
    private $grade;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

   
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kidskulaUsersUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

	public function getId(){ return $this->id; }
	public function setId($id){ $this->id=$id; }
	public function getGrade(){ return $this->grade; }
	public function setGrade($grade){ $this->grade=$grade; }
	public function getStatus(){ return $this->status; }
	public function setStatus($status){ $this->status=$status; }
}
