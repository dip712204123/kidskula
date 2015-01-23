<?php

namespace Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KidskulaSiteBlocks
 *
 * @ORM\Table(name="kidskula_site_blocks")
 * @ORM\Entity
 */
class KidskulaSiteBlocks
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
     * @ORM\Column(name="block_name", type="string", length=45, nullable=true)
     */
    private $blockName;



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
     * Set blockName
     *
     * @param string $blockName
     * @return KidskulaSiteBlocks
     */
    public function setBlockName($blockName)
    {
        $this->blockName = $blockName;

        return $this;
    }

    /**
     * Get blockName
     *
     * @return string 
     */
    public function getBlockName()
    {
        return $this->blockName;
    }
}
