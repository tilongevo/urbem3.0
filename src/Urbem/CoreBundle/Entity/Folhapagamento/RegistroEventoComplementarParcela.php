<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegistroEventoComplementarParcela
 */
class RegistroEventoComplementarParcela
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codRegistro;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var integer
     */
    private $parcela;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return RegistroEventoComplementarParcela
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
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return RegistroEventoComplementarParcela
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return RegistroEventoComplementarParcela
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
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return RegistroEventoComplementarParcela
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
     * Set parcela
     *
     * @param integer $parcela
     * @return RegistroEventoComplementarParcela
     */
    public function setParcela($parcela)
    {
        $this->parcela = $parcela;
        return $this;
    }

    /**
     * Get parcela
     *
     * @return integer
     */
    public function getParcela()
    {
        return $this->parcela;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoUltimoRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar $fkFolhapagamentoUltimoRegistroEventoComplementar
     * @return RegistroEventoComplementarParcela
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
