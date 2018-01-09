<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * UltimoRegistroEvento
 */
class UltimoRegistroEvento
{
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
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculado
     */
    private $fkFolhapagamentoEventoCalculado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculo
     */
    private $fkFolhapagamentoLogErroCalculo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoParcela
     */
    private $fkFolhapagamentoRegistroEventoParcela;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento
     */
    private $fkFolhapagamentoRegistroEvento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return UltimoRegistroEvento
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
     * @return UltimoRegistroEvento
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return UltimoRegistroEvento
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
     * Set FolhapagamentoEventoCalculado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculado $fkFolhapagamentoEventoCalculado
     * @return UltimoRegistroEvento
     */
    public function setFkFolhapagamentoEventoCalculado(\Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculado $fkFolhapagamentoEventoCalculado)
    {
        $fkFolhapagamentoEventoCalculado->setFkFolhapagamentoUltimoRegistroEvento($this);
        $this->fkFolhapagamentoEventoCalculado = $fkFolhapagamentoEventoCalculado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoEventoCalculado
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculado
     */
    public function getFkFolhapagamentoEventoCalculado()
    {
        return $this->fkFolhapagamentoEventoCalculado;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoLogErroCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculo $fkFolhapagamentoLogErroCalculo
     * @return UltimoRegistroEvento
     */
    public function setFkFolhapagamentoLogErroCalculo(\Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculo $fkFolhapagamentoLogErroCalculo)
    {
        $fkFolhapagamentoLogErroCalculo->setFkFolhapagamentoUltimoRegistroEvento($this);
        $this->fkFolhapagamentoLogErroCalculo = $fkFolhapagamentoLogErroCalculo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoLogErroCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculo
     */
    public function getFkFolhapagamentoLogErroCalculo()
    {
        return $this->fkFolhapagamentoLogErroCalculo;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoRegistroEventoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoParcela $fkFolhapagamentoRegistroEventoParcela
     * @return UltimoRegistroEvento
     */
    public function setFkFolhapagamentoRegistroEventoParcela(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoParcela $fkFolhapagamentoRegistroEventoParcela)
    {
        $fkFolhapagamentoRegistroEventoParcela->setFkFolhapagamentoUltimoRegistroEvento($this);
        $this->fkFolhapagamentoRegistroEventoParcela = $fkFolhapagamentoRegistroEventoParcela;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoRegistroEventoParcela
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoParcela
     */
    public function getFkFolhapagamentoRegistroEventoParcela()
    {
        return $this->fkFolhapagamentoRegistroEventoParcela;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento $fkFolhapagamentoRegistroEvento
     * @return UltimoRegistroEvento
     */
    public function setFkFolhapagamentoRegistroEvento(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento $fkFolhapagamentoRegistroEvento)
    {
        $this->codRegistro = $fkFolhapagamentoRegistroEvento->getCodRegistro();
        $this->timestamp = $fkFolhapagamentoRegistroEvento->getTimestamp();
        $this->codEvento = $fkFolhapagamentoRegistroEvento->getCodEvento();
        $this->fkFolhapagamentoRegistroEvento = $fkFolhapagamentoRegistroEvento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoRegistroEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento
     */
    public function getFkFolhapagamentoRegistroEvento()
    {
        return $this->fkFolhapagamentoRegistroEvento;
    }
}
