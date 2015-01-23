<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidsKulaContactQuestion
 *
 * @ORM\Table(name="kidskula_contact_question")
 * @ORM\Entity
 */
class KidsKulaContactQuestion
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
     * @ORM\Column(name="content", type="text", length=255, nullable=false)
     */
    private $content;
	

	 /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaContactCategory
     *
     * @ORM\OneToOne(targetEntity="Bundle\AdminBundle\Entity\KidsKulaContactCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent", referencedColumnName="id",nullable=true)
     * })
     */

    private $parent;
	
	/**
     * @var \Bundle\AdminBundle\Entity\KidsKulaContactCategory
     *
     * @ORM\OneToOne(targetEntity="Bundle\AdminBundle\Entity\KidsKulaContactCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_type", referencedColumnName="id")
     * })
     */

    private $userType;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    private $status;
   
    
	public function getId(){ return $this->id; }
	public function setId($id){ $this->id=$id; }
	public function getContent(){ return $this->content; }
	public function setContent($content){ $this->content=$content; }
	public function getParent(){ return $this->parent; }
	public function setParent(\Bundle\AdminBundle\Entity\KidsKulaContactCategory $parent){ $this->parent=$parent; }
	
	public function getUserType(){ return $this->userType; }
	public function setUserType(\Bundle\AdminBundle\Entity\KidsKulaContactCategory $userType){ $this->userType=$userType; }
	
	public function getStatus(){ return $this->status; }
	public function setStatus($status){ $this->status=$status; }
	
	function __toString() {
        return $this->content;
		//return $this->id;
    }
}
