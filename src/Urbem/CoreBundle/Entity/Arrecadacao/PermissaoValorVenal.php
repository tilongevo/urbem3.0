<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * PermissaoValorVenal
 */
class PermissaoValorVenal
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return PermissaoValorVenal
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
}
