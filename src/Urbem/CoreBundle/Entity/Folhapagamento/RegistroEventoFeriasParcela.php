<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegistroEventoFeriasParcela
 */
class RegistroEventoFeriasParcela
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
     * PK
     * @var string
     */
    private $desdobramento;

    /**
     * @var integer
     */
    private $parcela;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return RegistroEventoFeriasParcela
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
     * @return RegistroEventoFeriasParcela
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
     * @return RegistroEventoFeriasParcela
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
     * @return RegistroEventoFeriasParcela
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
     * Set parcela
     *
     * @param integer $parcela
     * @return RegistroEventoFeriasParcela
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
     * Set FolhapagamentoUltimoRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias $fkFolhapagamentoUltimoRegistroEventoFerias
     * @return RegistroEventoFeriasParcela
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
