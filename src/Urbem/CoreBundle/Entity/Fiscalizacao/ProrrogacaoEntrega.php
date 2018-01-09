<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * ProrrogacaoEntrega
 */
class ProrrogacaoEntrega
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtProrrogacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao
     */
    private $fkFiscalizacaoInicioFiscalizacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProrrogacaoEntrega
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ProrrogacaoEntrega
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set dtProrrogacao
     *
     * @param \DateTime $dtProrrogacao
     * @return ProrrogacaoEntrega
     */
    public function setDtProrrogacao(\DateTime $dtProrrogacao)
    {
        $this->dtProrrogacao = $dtProrrogacao;
        return $this;
    }

    /**
     * Get dtProrrogacao
     *
     * @return \DateTime
     */
    public function getDtProrrogacao()
    {
        return $this->dtProrrogacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoInicioFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao
     * @return ProrrogacaoEntrega
     */
    public function setFkFiscalizacaoInicioFiscalizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao $fkFiscalizacaoInicioFiscalizacao)
    {
        $this->codProcesso = $fkFiscalizacaoInicioFiscalizacao->getCodProcesso();
        $this->fkFiscalizacaoInicioFiscalizacao = $fkFiscalizacaoInicioFiscalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoInicioFiscalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacao
     */
    public function getFkFiscalizacaoInicioFiscalizacao()
    {
        return $this->fkFiscalizacaoInicioFiscalizacao;
    }
}
