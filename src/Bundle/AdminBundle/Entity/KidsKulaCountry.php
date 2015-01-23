<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaAdminSettings
 *
 * @ORM\Table(name="kidskula_countries")
 * @ORM\Entity
 */
class KidsKulaCountry
{

      /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=255, nullable=false)
     */
    private $countryCode;
    /**
     * @var string
     *
     * @ORM\Column(name="country_name", type="string", length=255, nullable=false)
     */
    private $countryName;

	public function getId(){
	
	return $this->id;
	
	}
	
	public function getCountryCode(){
	
	return $this->countryCode;
	
	}
	
    public function setCountryCode($countryCode){
	
	$this->countryCode=$countryCode;
	
	}
	
	
	public function getCountryName(){
	
	return $this->countryName;
	
	}
	
    public function setCountryName($countryName){
	
	$this->countryName=$countryName;
	
	}
	
	public function __toString()
    {
	   return $this->countryName;
	}	
}