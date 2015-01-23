<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaGames
 *
 * @ORM\Table(name="kidskula_games")
 * @ORM\Entity
 */
class KidskulaGames
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="game_add_date", type="datetime", nullable=false)
     */
    private $gameAddDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_date", type="datetime", nullable=true)
     */
    private $modifiedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=255, nullable=true)
     */
    private $genre;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer", nullable=true)
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="rating", type="string", length=45, nullable=true)
     */
    private $rating;

    /**
     * @var boolean
     *
     * @ORM\Column(name="priority", type="boolean", nullable=true)
     */
    private $priority;

    /**
     * @var string
     *
     * @ORM\Column(name="providers", type="string", length=255, nullable=true)
     */
    private $providers;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="game_path", type="string", length=255, nullable=true)
     */
    private $gamePath;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return KidskulaGames
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return KidskulaGames
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return KidskulaGames
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set gameAddDate
     *
     * @param \DateTime $gameAddDate
     * @return KidskulaGames
     */
    public function setGameAddDate($gameAddDate)
    {
        $this->gameAddDate = $gameAddDate;

        return $this;
    }

    /**
     * Get gameAddDate
     *
     * @return \DateTime 
     */
    public function getGameAddDate()
    {
        return $this->gameAddDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return KidskulaGames
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime 
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set genre
     *
     * @param string $genre
     * @return KidskulaGames
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return KidskulaGames
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set rating
     *
     * @param string $rating
     * @return KidskulaGames
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return string 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set priority
     *
     * @param boolean $priority
     * @return KidskulaGames
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return boolean 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set providers
     *
     * @param string $providers
     * @return KidskulaGames
     */
    public function setProviders($providers)
    {
        $this->providers = $providers;

        return $this;
    }

    /**
     * Get providers
     *
     * @return string 
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return KidskulaGames
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set gamePath
     *
     * @param string $gamePath
     * @return KidskulaGames
     */
    public function setGamePath($gamePath)
    {
        $this->gamePath = $gamePath;

        return $this;
    }

    /**
     * Get gamePath
     *
     * @return string 
     */
    public function getGamePath()
    {
        return $this->gamePath;
    }
}
