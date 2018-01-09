<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * LogErroCalculoRescisao
 */
class LogErroCalculoRescisao
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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao
     */
    private $fkFolhapagamentoUltimoRegistroEventoRescisao;

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
     * @return LogErroCalculoRescisao
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
     * @return LogErroCalculoRescisao
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
     * @return LogErroCalculoRescisao
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
     * @return LogErroCalculoRescisao
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
     * @return LogErroCalculoRescisao
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
     * Set FolhapagamentoUltimoRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao $fkFolhapagamentoUltimoRegistroEventoRescisao
     * @return LogErroCalculoRescisao
     */
    public function setFkFolhapagamentoUltimoRegistroEventoRescisao(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao $fkFolhapagamentoUltimoRegistroEventoRescisao)
    {
        $this->desdobramento = $fkFolhapagamentoUltimoRegistroEventoRescisao->getDesdobramento();
        $this->timestamp = $fkFolhapagamentoUltimoRegistroEventoRescisao->getTimestamp();
        $this->codRegistro = $fkFolhapagamentoUltimoRegistroEventoRescisao->getCodRegistro();
        $this->codEvento = $fkFolhapagamentoUltimoRegistroEventoRescisao->getCodEvento();
        $this->fkFolhapagamentoUltimoRegistroEventoRescisao = $fkFolhapagamentoUltimoRegistroEventoRescisao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoUltimoRegistroEventoRescisao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao
     */
    public function getFkFolhapagamentoUltimoRegistroEventoRescisao()
    {
        return $this->fkFolhapagamentoUltimoRegistroEventoRescisao;
    }
}
