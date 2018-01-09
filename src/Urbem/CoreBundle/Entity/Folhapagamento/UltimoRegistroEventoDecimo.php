<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * UltimoRegistroEventoDecimo
 */
class UltimoRegistroEventoDecimo
{
    /**
     * PK
     * @var string
     */
    private $desdobramento;

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
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculado
     */
    private $fkFolhapagamentoEventoDecimoCalculado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoDecimo
     */
    private $fkFolhapagamentoLogErroCalculoDecimo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimoParcela
     */
    private $fkFolhapagamentoRegistroEventoDecimoParcela;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo
     */
    private $fkFolhapagamentoRegistroEventoDecimo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return UltimoRegistroEventoDecimo
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return UltimoRegistroEventoDecimo
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
     * @return UltimoRegistroEventoDecimo
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
     * @return UltimoRegistroEventoDecimo
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
     * OneToOne (inverse side)
     * Set FolhapagamentoEventoDecimoCalculado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculado $fkFolhapagamentoEventoDecimoCalculado
     * @return UltimoRegistroEventoDecimo
     */
    public function setFkFolhapagamentoEventoDecimoCalculado(\Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculado $fkFolhapagamentoEventoDecimoCalculado)
    {
        $fkFolhapagamentoEventoDecimoCalculado->setFkFolhapagamentoUltimoRegistroEventoDecimo($this);
        $this->fkFolhapagamentoEventoDecimoCalculado = $fkFolhapagamentoEventoDecimoCalculado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoEventoDecimoCalculado
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoDecimoCalculado
     */
    public function getFkFolhapagamentoEventoDecimoCalculado()
    {
        return $this->fkFolhapagamentoEventoDecimoCalculado;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoLogErroCalculoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoDecimo $fkFolhapagamentoLogErroCalculoDecimo
     * @return UltimoRegistroEventoDecimo
     */
    public function setFkFolhapagamentoLogErroCalculoDecimo(\Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoDecimo $fkFolhapagamentoLogErroCalculoDecimo)
    {
        $fkFolhapagamentoLogErroCalculoDecimo->setFkFolhapagamentoUltimoRegistroEventoDecimo($this);
        $this->fkFolhapagamentoLogErroCalculoDecimo = $fkFolhapagamentoLogErroCalculoDecimo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoLogErroCalculoDecimo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoDecimo
     */
    public function getFkFolhapagamentoLogErroCalculoDecimo()
    {
        return $this->fkFolhapagamentoLogErroCalculoDecimo;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoRegistroEventoDecimoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimoParcela $fkFolhapagamentoRegistroEventoDecimoParcela
     * @return UltimoRegistroEventoDecimo
     */
    public function setFkFolhapagamentoRegistroEventoDecimoParcela(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimoParcela $fkFolhapagamentoRegistroEventoDecimoParcela)
    {
        $fkFolhapagamentoRegistroEventoDecimoParcela->setFkFolhapagamentoUltimoRegistroEventoDecimo($this);
        $this->fkFolhapagamentoRegistroEventoDecimoParcela = $fkFolhapagamentoRegistroEventoDecimoParcela;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoRegistroEventoDecimoParcela
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimoParcela
     */
    public function getFkFolhapagamentoRegistroEventoDecimoParcela()
    {
        return $this->fkFolhapagamentoRegistroEventoDecimoParcela;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo $fkFolhapagamentoRegistroEventoDecimo
     * @return UltimoRegistroEventoDecimo
     */
    public function setFkFolhapagamentoRegistroEventoDecimo(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo $fkFolhapagamentoRegistroEventoDecimo)
    {
        $this->codRegistro = $fkFolhapagamentoRegistroEventoDecimo->getCodRegistro();
        $this->timestamp = $fkFolhapagamentoRegistroEventoDecimo->getTimestamp();
        $this->desdobramento = $fkFolhapagamentoRegistroEventoDecimo->getDesdobramento();
        $this->codEvento = $fkFolhapagamentoRegistroEventoDecimo->getCodEvento();
        $this->fkFolhapagamentoRegistroEventoDecimo = $fkFolhapagamentoRegistroEventoDecimo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoRegistroEventoDecimo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo
     */
    public function getFkFolhapagamentoRegistroEventoDecimo()
    {
        return $this->fkFolhapagamentoRegistroEventoDecimo;
    }
}
