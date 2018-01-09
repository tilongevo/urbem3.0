<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * VwLoteAtivoView
 */
class VwLoteAtivoView
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
     * @var \DateTime
     */
    private $dtInscricao;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return VwLoteAtivo
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
     * @return VwLoteAtivo
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
     * Set dtInscricao
     *
     * @param \DateTime $dtInscricao
     * @return VwLoteAtivo
     */
    public function setDtInscricao(\DateTime $dtInscricao = null)
    {
        $this->dtInscricao = $dtInscricao;
        return $this;
    }

    /**
     * Get dtInscricao
     *
     * @return \DateTime
     */
    public function getDtInscricao()
    {
        return $this->dtInscricao;
    }
}
