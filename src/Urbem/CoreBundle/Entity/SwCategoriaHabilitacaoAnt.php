<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCategoriaHabilitacaoAnt
 */
class SwCategoriaHabilitacaoAnt
{
    /**
     * PK
     * @var integer
     */
    private $codCategoria;

    /**
     * @var string
     */
    private $nomCategoria;


    /**
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return SwCategoriaHabilitacaoAnt
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * Set nomCategoria
     *
     * @param string $nomCategoria
     * @return SwCategoriaHabilitacaoAnt
     */
    public function setNomCategoria($nomCategoria)
    {
        $this->nomCategoria = $nomCategoria;
        return $this;
    }

    /**
     * Get nomCategoria
     *
     * @return string
     */
    public function getNomCategoria()
    {
        return $this->nomCategoria;
    }
}
