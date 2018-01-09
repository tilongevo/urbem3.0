<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * UltimoRegistroEventoFerias
 */
class UltimoRegistroEventoFerias
{
    /**
     * PK
     * @var integer
     */
    private $codEvento;

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
     * @var string
     */
    private $desdobramento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoFerias
     */
    private $fkFolhapagamentoLogErroCalculoFerias;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculado
     */
    private $fkFolhapagamentoEventoFeriasCalculado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFeriasParcela
     */
    private $fkFolhapagamentoRegistroEventoFeriasParcela;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias
     */
    private $fkFolhapagamentoRegistroEventoFerias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return UltimoRegistroEventoFerias
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return UltimoRegistroEventoFerias
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
     * @return UltimoRegistroEventoFerias
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return UltimoRegistroEventoFerias
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
     * OneToOne (inverse side)
     * Set FolhapagamentoLogErroCalculoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoFerias $fkFolhapagamentoLogErroCalculoFerias
     * @return UltimoRegistroEventoFerias
     */
    public function setFkFolhapagamentoLogErroCalculoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoFerias $fkFolhapagamentoLogErroCalculoFerias)
    {
        $fkFolhapagamentoLogErroCalculoFerias->setFkFolhapagamentoUltimoRegistroEventoFerias($this);
        $this->fkFolhapagamentoLogErroCalculoFerias = $fkFolhapagamentoLogErroCalculoFerias;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoLogErroCalculoFerias
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoFerias
     */
    public function getFkFolhapagamentoLogErroCalculoFerias()
    {
        return $this->fkFolhapagamentoLogErroCalculoFerias;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoEventoFeriasCalculado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculado $fkFolhapagamentoEventoFeriasCalculado
     * @return UltimoRegistroEventoFerias
     */
    public function setFkFolhapagamentoEventoFeriasCalculado(\Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculado $fkFolhapagamentoEventoFeriasCalculado)
    {
        $fkFolhapagamentoEventoFeriasCalculado->setFkFolhapagamentoUltimoRegistroEventoFerias($this);
        $this->fkFolhapagamentoEventoFeriasCalculado = $fkFolhapagamentoEventoFeriasCalculado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoEventoFeriasCalculado
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoFeriasCalculado
     */
    public function getFkFolhapagamentoEventoFeriasCalculado()
    {
        return $this->fkFolhapagamentoEventoFeriasCalculado;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoRegistroEventoFeriasParcela
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFeriasParcela $fkFolhapagamentoRegistroEventoFeriasParcela
     * @return UltimoRegistroEventoFerias
     */
    public function setFkFolhapagamentoRegistroEventoFeriasParcela(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFeriasParcela $fkFolhapagamentoRegistroEventoFeriasParcela)
    {
        $fkFolhapagamentoRegistroEventoFeriasParcela->setFkFolhapagamentoUltimoRegistroEventoFerias($this);
        $this->fkFolhapagamentoRegistroEventoFeriasParcela = $fkFolhapagamentoRegistroEventoFeriasParcela;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoRegistroEventoFeriasParcela
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFeriasParcela
     */
    public function getFkFolhapagamentoRegistroEventoFeriasParcela()
    {
        return $this->fkFolhapagamentoRegistroEventoFeriasParcela;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias $fkFolhapagamentoRegistroEventoFerias
     * @return UltimoRegistroEventoFerias
     */
    public function setFkFolhapagamentoRegistroEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias $fkFolhapagamentoRegistroEventoFerias)
    {
        $this->codRegistro = $fkFolhapagamentoRegistroEventoFerias->getCodRegistro();
        $this->timestamp = $fkFolhapagamentoRegistroEventoFerias->getTimestamp();
        $this->codEvento = $fkFolhapagamentoRegistroEventoFerias->getCodEvento();
        $this->desdobramento = $fkFolhapagamentoRegistroEventoFerias->getDesdobramento();
        $this->fkFolhapagamentoRegistroEventoFerias = $fkFolhapagamentoRegistroEventoFerias;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoRegistroEventoFerias
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias
     */
    public function getFkFolhapagamentoRegistroEventoFerias()
    {
        return $this->fkFolhapagamentoRegistroEventoFerias;
    }
}
