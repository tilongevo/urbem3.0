<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * LogErroCalculoDecimo
 */
class LogErroCalculoDecimo
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
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo
     */
    private $fkFolhapagamentoUltimoRegistroEventoDecimo;

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
     * @return LogErroCalculoDecimo
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
     * @return LogErroCalculoDecimo
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
     * @return LogErroCalculoDecimo
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return LogErroCalculoDecimo
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
     * @return LogErroCalculoDecimo
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
     * Set FolhapagamentoUltimoRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo $fkFolhapagamentoUltimoRegistroEventoDecimo
     * @return LogErroCalculoDecimo
     */
    public function setFkFolhapagamentoUltimoRegistroEventoDecimo(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo $fkFolhapagamentoUltimoRegistroEventoDecimo)
    {
        $this->desdobramento = $fkFolhapagamentoUltimoRegistroEventoDecimo->getDesdobramento();
        $this->timestamp = $fkFolhapagamentoUltimoRegistroEventoDecimo->getTimestamp();
        $this->codRegistro = $fkFolhapagamentoUltimoRegistroEventoDecimo->getCodRegistro();
        $this->codEvento = $fkFolhapagamentoUltimoRegistroEventoDecimo->getCodEvento();
        $this->fkFolhapagamentoUltimoRegistroEventoDecimo = $fkFolhapagamentoUltimoRegistroEventoDecimo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoUltimoRegistroEventoDecimo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo
     */
    public function getFkFolhapagamentoUltimoRegistroEventoDecimo()
    {
        return $this->fkFolhapagamentoUltimoRegistroEventoDecimo;
    }
}
