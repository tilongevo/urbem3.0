<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * UltimoRegistroEventoComplementar
 */
class UltimoRegistroEventoComplementar
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
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculado
     */
    private $fkFolhapagamentoEventoComplementarCalculado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementarParcela
     */
    private $fkFolhapagamentoRegistroEventoComplementarParcela;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoComplementar
     */
    private $fkFolhapagamentoLogErroCalculoComplementar;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar
     */
    private $fkFolhapagamentoRegistroEventoComplementar;

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
     * @return UltimoRegistroEventoComplementar
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
     * @return UltimoRegistroEventoComplementar
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
     * @return UltimoRegistroEventoComplementar
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
     * @return UltimoRegistroEventoComplementar
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
     * OneToOne (inverse side)
     * Set FolhapagamentoEventoComplementarCalculado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculado $fkFolhapagamentoEventoComplementarCalculado
     * @return UltimoRegistroEventoComplementar
     */
    public function setFkFolhapagamentoEventoComplementarCalculado(\Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculado $fkFolhapagamentoEventoComplementarCalculado)
    {
        $fkFolhapagamentoEventoComplementarCalculado->setFkFolhapagamentoUltimoRegistroEventoComplementar($this);
        $this->fkFolhapagamentoEventoComplementarCalculado = $fkFolhapagamentoEventoComplementarCalculado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoEventoComplementarCalculado
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoComplementarCalculado
     */
    public function getFkFolhapagamentoEventoComplementarCalculado()
    {
        return $this->fkFolhapagamentoEventoComplementarCalculado;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoRegistroEventoComplementarParcela
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementarParcela $fkFolhapagamentoRegistroEventoComplementarParcela
     * @return UltimoRegistroEventoComplementar
     */
    public function setFkFolhapagamentoRegistroEventoComplementarParcela(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementarParcela $fkFolhapagamentoRegistroEventoComplementarParcela)
    {
        $fkFolhapagamentoRegistroEventoComplementarParcela->setFkFolhapagamentoUltimoRegistroEventoComplementar($this);
        $this->fkFolhapagamentoRegistroEventoComplementarParcela = $fkFolhapagamentoRegistroEventoComplementarParcela;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoRegistroEventoComplementarParcela
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementarParcela
     */
    public function getFkFolhapagamentoRegistroEventoComplementarParcela()
    {
        return $this->fkFolhapagamentoRegistroEventoComplementarParcela;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoLogErroCalculoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoComplementar $fkFolhapagamentoLogErroCalculoComplementar
     * @return UltimoRegistroEventoComplementar
     */
    public function setFkFolhapagamentoLogErroCalculoComplementar(\Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoComplementar $fkFolhapagamentoLogErroCalculoComplementar)
    {
        $fkFolhapagamentoLogErroCalculoComplementar->setFkFolhapagamentoUltimoRegistroEventoComplementar($this);
        $this->fkFolhapagamentoLogErroCalculoComplementar = $fkFolhapagamentoLogErroCalculoComplementar;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoLogErroCalculoComplementar
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoComplementar
     */
    public function getFkFolhapagamentoLogErroCalculoComplementar()
    {
        return $this->fkFolhapagamentoLogErroCalculoComplementar;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar
     * @return UltimoRegistroEventoComplementar
     */
    public function setFkFolhapagamentoRegistroEventoComplementar(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar)
    {
        $this->codRegistro = $fkFolhapagamentoRegistroEventoComplementar->getCodRegistro();
        $this->timestamp = $fkFolhapagamentoRegistroEventoComplementar->getTimestamp();
        $this->codEvento = $fkFolhapagamentoRegistroEventoComplementar->getCodEvento();
        $this->codConfiguracao = $fkFolhapagamentoRegistroEventoComplementar->getCodConfiguracao();
        $this->fkFolhapagamentoRegistroEventoComplementar = $fkFolhapagamentoRegistroEventoComplementar;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoRegistroEventoComplementar
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar
     */
    public function getFkFolhapagamentoRegistroEventoComplementar()
    {
        return $this->fkFolhapagamentoRegistroEventoComplementar;
    }
}
