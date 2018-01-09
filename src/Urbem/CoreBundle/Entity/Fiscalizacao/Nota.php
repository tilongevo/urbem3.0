<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * Nota
 */
class Nota
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var string
     */
    private $nroSerie;

    /**
     * @var integer
     */
    private $nroNota;

    /**
     * @var integer
     */
    private $valorNota;


    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return Nota
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set nroSerie
     *
     * @param string $nroSerie
     * @return Nota
     */
    public function setNroSerie($nroSerie)
    {
        $this->nroSerie = $nroSerie;
        return $this;
    }

    /**
     * Get nroSerie
     *
     * @return string
     */
    public function getNroSerie()
    {
        return $this->nroSerie;
    }

    /**
     * Set nroNota
     *
     * @param integer $nroNota
     * @return Nota
     */
    public function setNroNota($nroNota)
    {
        $this->nroNota = $nroNota;
        return $this;
    }

    /**
     * Get nroNota
     *
     * @return integer
     */
    public function getNroNota()
    {
        return $this->nroNota;
    }

    /**
     * Set valorNota
     *
     * @param integer $valorNota
     * @return Nota
     */
    public function setValorNota($valorNota)
    {
        $this->valorNota = $valorNota;
        return $this;
    }

    /**
     * Get valorNota
     *
     * @return integer
     */
    public function getValorNota()
    {
        return $this->valorNota;
    }
}
