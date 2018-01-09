<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * VwCnpjCpfView
 */
class VwCnpjCpfView
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $numDocumento;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SwVwCnpjCpf
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set numDocumento
     *
     * @param string $numDocumento
     * @return SwVwCnpjCpf
     */
    public function setNumDocumento($numDocumento = null)
    {
        $this->numDocumento = $numDocumento;
        return $this;
    }

    /**
     * Get numDocumento
     *
     * @return string
     */
    public function getNumDocumento()
    {
        return $this->numDocumento;
    }
}
