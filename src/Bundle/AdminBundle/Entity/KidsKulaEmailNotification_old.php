<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="kidskula_email_notification")
 */
class KidsKulaEmailNotification  {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer",name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email_code", type="string", length=255, nullable=false)
     */
    private $emailCode;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=false)
     */
    private $subject;
	
     /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", nullable=false)
     */
    private $content;
	
    /**
     * @var \Bundle\AdminBundle\Entity\KidsKulaUsers
     *
     * @ORM\OneToOne(targetEntity="\Bundle\AdminBundle\Entity\KidsKulaUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id", unique=false)
     * })
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;


	public function getId(){ return $this->id; }
	public function setId($id){ $this->id=$id; }
	public function getEmailCode(){ return $this->emailCode; }
	public function setEmailCode($emailCode){ $this->emailCode=$emailCode; }
	public function getSubject(){ return $this->subject; }
	public function setSubject($subject){ $this->subject=$subject; }
	public function getContent(){ return $this->content; }
	public function setContent($content){ $this->content=$content; }
	public function getCreatedBy(){ return $this->createdBy; }
	public function setCreatedBy(\Bundle\AdminBundle\Entity\KidsKulaUsers $createdBy){ $this->createdBy=$createdBy; }
	public function getCreatedDate(){ return $this->createdDate; }
	public function setCreatedDate($createdDate){ $this->createdDate=$createdDate; }
}
