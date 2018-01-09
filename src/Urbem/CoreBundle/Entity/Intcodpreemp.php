<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * Intcodpreemp
 */
class Intcodpreemp
{
    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;


    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return Intcodpreemp
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }
}
