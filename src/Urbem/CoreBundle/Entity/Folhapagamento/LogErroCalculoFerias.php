<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * LogErroCalculoFerias
 */
class LogErroCalculoFerias
{
    /**
     * PK
     * @var integer
     */
    private $codRegistro;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var string
     */
    private $desdobramento;

    /**
     * @var string
     */
    private $erro;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias
     */
    private $fkFolhapagamentoUltimoRegistroEventoFerias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return LogErroCalculoFerias
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
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return LogErroCalculoFerias
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return LogErroCalculoFerias
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return LogErroCalculoFerias
     */
    public function setDesdobramento($desdobramento)
    {
        $this->desdobramento = $desdobramento;
        return $this;
    }

    /**
     * Get desdobramento
     *
     * @return string
     */
    public function getDesdobramento()
    {
        return $this->desdobramento;
    }

    /**
     * Set erro
     *
     * @param string $erro
     * @return LogErroCalculoFerias
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
     * Set FolhapagamentoUltimoRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias $fkFolhapagamentoUltimoRegistroEventoFerias
     * @return LogErroCalculoFerias
     */
    public function setFkFolhapagamentoUltimoRegistroEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias $fkFolhapagamentoUltimoRegistroEventoFerias)
    {
        $this->codEvento = $fkFolhapagamentoUltimoRegistroEventoFerias->getCodEvento();
        $this->timestamp = $fkFolhapagamentoUltimoRegistroEventoFerias->getTimestamp();
        $this->codRegistro = $fkFolhapagamentoUltimoRegistroEventoFerias->getCodRegistro();
        $this->desdobramento = $fkFolhapagamentoUltimoRegistroEventoFerias->getDesdobramento();
        $this->fkFolhapagamentoUltimoRegistroEventoFerias = $fkFolhapagamentoUltimoRegistroEventoFerias;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoUltimoRegistroEventoFerias
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias
     */
    public function getFkFolhapagamentoUltimoRegistroEventoFerias()
    {
        return $this->fkFolhapagamentoUltimoRegistroEventoFerias;
    }
}
