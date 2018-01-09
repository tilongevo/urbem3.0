<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * LogErroCalculoComplementar
 */
class LogErroCalculoComplementar
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

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
     * @var string
     */
    private $erro;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar
     */
    private $fkFolhapagamentoUltimoRegistroEventoComplementar;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return LogErroCalculoComplementar
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return LogErroCalculoComplementar
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
     * @return LogErroCalculoComplementar
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
     * @return LogErroCalculoComplementar
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
     * Set erro
     *
     * @param string $erro
     * @return LogErroCalculoComplementar
     */
    public function setErro($erro = null)
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
     * Set FolhapagamentoUltimoRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar $fkFolhapagamentoUltimoRegistroEventoComplementar
     * @return LogErroCalculoComplementar
     */
    public function setFkFolhapagamentoUltimoRegistroEventoComplementar(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar $fkFolhapagamentoUltimoRegistroEventoComplementar)
    {
        $this->timestamp = $fkFolhapagamentoUltimoRegistroEventoComplementar->getTimestamp();
        $this->codRegistro = $fkFolhapagamentoUltimoRegistroEventoComplementar->getCodRegistro();
        $this->codEvento = $fkFolhapagamentoUltimoRegistroEventoComplementar->getCodEvento();
        $this->codConfiguracao = $fkFolhapagamentoUltimoRegistroEventoComplementar->getCodConfiguracao();
        $this->fkFolhapagamentoUltimoRegistroEventoComplementar = $fkFolhapagamentoUltimoRegistroEventoComplementar;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoUltimoRegistroEventoComplementar
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar
     */
    public function getFkFolhapagamentoUltimoRegistroEventoComplementar()
    {
        return $this->fkFolhapagamentoUltimoRegistroEventoComplementar;
    }
}
