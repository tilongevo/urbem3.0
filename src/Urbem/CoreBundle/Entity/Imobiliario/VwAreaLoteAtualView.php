<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * VwAreaLoteAtualView
 */
class VwAreaLoteAtualView
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codGrandeza;

    /**
     * @var integer
     */
    private $codUnidade;

    /**
     * @var integer
     */
    private $areaReal;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return VwAreaLoteAtual
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return VwAreaLoteAtual
     */
    public function setTimestamp(\DateTime $timestamp = null)
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
     * Set codGrandeza
     *
     * @param integer $codGrandeza
     * @return VwAreaLoteAtual
     */
    public function setCodGrandeza($codGrandeza = null)
    {
        $this->codGrandeza = $codGrandeza;
        return $this;
    }

    /**
     * Get codGrandeza
     *
     * @return integer
     */
    public function getCodGrandeza()
    {
        return $this->codGrandeza;
    }

    /**
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return VwAreaLoteAtual
     */
    public function setCodUnidade($codUnidade = null)
    {
        $this->codUnidade = $codUnidade;
        return $this;
    }

    /**
     * Get codUnidade
     *
     * @return integer
     */
    public function getCodUnidade()
    {
        return $this->codUnidade;
    }

    /**
     * Set areaReal
     *
     * @param integer $areaReal
     * @return VwAreaLoteAtual
     */
    public function setAreaReal($areaReal = null)
    {
        $this->areaReal = $areaReal;
        return $this;
    }

    /**
     * Get areaReal
     *
     * @return integer
     */
    public function getAreaReal()
    {
        return $this->areaReal;
    }
}
