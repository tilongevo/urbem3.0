<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * Intcont1
 */
class Intcont1
{
    /**
     * PK
     * @var integer
     */
    private $count;


    /**
     * Set count
     *
     * @param integer $count
     * @return Intcont1
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }
}
