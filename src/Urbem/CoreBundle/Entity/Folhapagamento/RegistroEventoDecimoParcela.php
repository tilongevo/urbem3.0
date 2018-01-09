<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegistroEventoDecimoParcela
 */
class RegistroEventoDecimoParcela
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
     * @var string
     */
    private $desdobramento;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * @var integer
     */
    private $parcela;

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
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return RegistroEventoDecimoParcela
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
     * @return RegistroEventoDecimoParcela
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
     * @return RegistroEventoDecimoParcela
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return RegistroEventoDecimoParcela
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
     * Set parcela
     *
     * @param integer $parcela
     * @return RegistroEventoDecimoParcela
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
     * Set FolhapagamentoUltimoRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo $fkFolhapagamentoUltimoRegistroEventoDecimo
     * @return RegistroEventoDecimoParcela
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
