<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kidskulaactivitylog
 *
 * @ORM\Table(name="student_activity_log")
 * @ORM\Entity
 */
class Kidskulaactivitylog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="page_section_name", type="string", nullable=true)
     */
    private $pagesectionname;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_visit_time", type="integer", nullable=true)
     */
    private $totalvisittime;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    
    private $startdate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $enddate;
   
    /**
     * @var \Bundle\AdminBundle\Entity\KidskulaUsers
     *
     * @ORM\ManyToOne(targetEntity="Bundle\AdminBundle\Entity\KidskulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="	user_id", referencedColumnName="id")
     * })
     */
    private $userid;



    public function getId() {
        return $this->id;
    }

    public function getPagesectionname() {
        return $this->pagesectionname;
    }

    public function getTotalvisittime() {
        return $this->totalvisittime;
    }

    public function getStartdate() {
        return $this->startdate;
    }

    public function getEnddate() {
        return $this->enddate;
    }

    public function getUserid() {
        return $this->userid;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setPagesectionname($pagesectionname) {
        $this->pagesectionname = $pagesectionname;
    }

    public function setTotalvisittime($totalvisittime) {
        $this->totalvisittime = $totalvisittime;
    }

    public function setStartdate(\DateTime $startdate) {
        $this->startdate = $startdate;
    }

    public function setEnddate(\DateTime $enddate) {
        $this->enddate = $enddate;
    }

    public function setUserid(\Bundle\AdminBundle\Entity\KidskulaUsers $userid) {
        $this->userid = $userid;
    }


}
