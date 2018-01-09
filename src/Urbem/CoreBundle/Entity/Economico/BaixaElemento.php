<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * BaixaElemento
 */
class BaixaElemento
{
    /**
     * PK
     * @var integer
     */
    private $codElemento;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $motivo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codElemento
     *
     * @param integer $codElemento
     * @return BaixaElemento
     */
    public function setCodElemento($codElemento)
    {
        $this->codElemento = $codElemento;
        return $this;
    }

    /**
     * Get codElemento
     *
     * @return integer
     */
    public function getCodElemento()
    {
        return $this->codElemento;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return BaixaElemento
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return BaixaElemento
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }
}
