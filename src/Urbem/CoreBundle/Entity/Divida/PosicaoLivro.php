<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * PosicaoLivro
 */
class PosicaoLivro
{
    /**
     * PK
     * @var integer
     */
    private $numLivro;

    /**
     * @var integer
     */
    private $numPagina;


    /**
     * Set numLivro
     *
     * @param integer $numLivro
     * @return PosicaoLivro
     */
    public function setNumLivro($numLivro)
    {
        $this->numLivro = $numLivro;
        return $this;
    }

    /**
     * Get numLivro
     *
     * @return integer
     */
    public function getNumLivro()
    {
        return $this->numLivro;
    }

    /**
     * Set numPagina
     *
     * @param integer $numPagina
     * @return PosicaoLivro
     */
    public function setNumPagina($numPagina)
    {
        $this->numPagina = $numPagina;
        return $this;
    }

    /**
     * Get numPagina
     *
     * @return integer
     */
    public function getNumPagina()
    {
        return $this->numPagina;
    }
}
