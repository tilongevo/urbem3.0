<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoServidorPrevidencia
 */
class ContratoServidorPrevidencia
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codPrevidencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var boolean
     */
    private $boExcluido = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia
     */
    private $fkFolhapagamentoPrevidencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorPrevidencia
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codPrevidencia
     *
     * @param integer $codPrevidencia
     * @return ContratoServidorPrevidencia
     */
    public function setCodPrevidencia($codPrevidencia)
    {
        $this->codPrevidencia = $codPrevidencia;
        return $this;
    }

    /**
     * Get codPrevidencia
     *
     * @return integer
     */
    public function getCodPrevidencia()
    {
        return $this->codPrevidencia;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ContratoServidorPrevidencia
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set boExcluido
     *
     * @param boolean $boExcluido
     * @return ContratoServidorPrevidencia
     */
    public function setBoExcluido($boExcluido)
    {
        $this->boExcluido = $boExcluido;
        return $this;
    }

    /**
     * Get boExcluido
     *
     * @return boolean
     */
    public function getBoExcluido()
    {
        return $this->boExcluido;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorPrevidencia
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->codContrato = $fkPessoalContratoServidor->getCodContrato();
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia
     * @return ContratoServidorPrevidencia
     */
    public function setFkFolhapagamentoPrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia)
    {
        $this->codPrevidencia = $fkFolhapagamentoPrevidencia->getCodPrevidencia();
        $this->fkFolhapagamentoPrevidencia = $fkFolhapagamentoPrevidencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia
     */
    public function getFkFolhapagamentoPrevidencia()
    {
        return $this->fkFolhapagamentoPrevidencia;
    }
}
