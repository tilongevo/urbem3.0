<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * LogErroCalculo
 */
class LogErroCalculo
{
    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var integer
     */
    private $codRegistro;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $erro;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento
     */
    private $fkFolhapagamentoUltimoRegistroEvento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return LogErroCalculo
     */
    public function setCodEvento($codEvento)
    {
        $this->codEvento = $codEvento;
        return $this;
    }

    /**
     * Get codEvento
     *
     * @return integer
     */
    public function getCodEvento()
    {
        return $this->codEvento;
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return LogErroCalculo
     */
    public function setCodRegistro($codRegistro)
    {
        $this->codRegistro = $codRegistro;
        return $this;
    }

    /**
     * Get codRegistro
     *
     * @return integer
     */
    public function getCodRegistro()
    {
        return $this->codRegistro;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return LogErroCalculo
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
     * Set erro
     *
     * @param string $erro
     * @return LogErroCalculo
     */
    public function setErro($erro)
    {
        $this->erro = $erro;
        return $this;
    }

    /**
     * Get erro
     *
     * @return string
     */
    public function getErro()
    {
        return $this->erro;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoUltimoRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento $fkFolhapagamentoUltimoRegistroEvento
     * @return LogErroCalculo
     */
    public function setFkFolhapagamentoUltimoRegistroEvento(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento $fkFolhapagamentoUltimoRegistroEvento)
    {
        $this->codRegistro = $fkFolhapagamentoUltimoRegistroEvento->getCodRegistro();
        $this->timestamp = $fkFolhapagamentoUltimoRegistroEvento->getTimestamp();
        $this->codEvento = $fkFolhapagamentoUltimoRegistroEvento->getCodEvento();
        $this->fkFolhapagamentoUltimoRegistroEvento = $fkFolhapagamentoUltimoRegistroEvento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoUltimoRegistroEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento
     */
    public function getFkFolhapagamentoUltimoRegistroEvento()
    {
        return $this->fkFolhapagamentoUltimoRegistroEvento;
    }
}
