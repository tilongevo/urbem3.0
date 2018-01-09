<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegistroEventoParcela
 */
class RegistroEventoParcela
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
     * @var integer
     */
    private $parcela;

    /**
     * @var integer
     */
    private $mesCarencia = 0;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento
     */
    private $fkFolhapagamentoUltimoRegistroEvento;

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
     * @return RegistroEventoParcela
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
     * @return RegistroEventoParcela
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
     * @return RegistroEventoParcela
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
     * @return RegistroEventoParcela
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
     * Set mesCarencia
     *
     * @param integer $mesCarencia
     * @return RegistroEventoParcela
     */
    public function setMesCarencia($mesCarencia)
    {
        $this->mesCarencia = $mesCarencia;
        return $this;
    }

    /**
     * Get mesCarencia
     *
     * @return integer
     */
    public function getMesCarencia()
    {
        return $this->mesCarencia;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoUltimoRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento $fkFolhapagamentoUltimoRegistroEvento
     * @return RegistroEventoParcela
     */
    public function setFkFolhapagamentoUltimoRegistroEvento(\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento $fkFolhapagamentoUltimoRegistroEvento)
    {
        $this->codRegistro = $fkFolhapagamentoUltimoRegistroEvento->getCodRegistro();
        $this->timestamp = $fkFolhapagamentoUltimoRegistroEvento->getTimestamp();
        $this->codEvento = $fkFolhapagamentoUltimoRegistroEvento->getCodEvento();
        $this->fkFolhapagamentoUltimoRegistroEvento = $fkFolhapagamentoUltimoRegistroEvento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoUltimoRegistroEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento
     */
    public function getFkFolhapagamentoUltimoRegistroEvento()
    {
        return $this->fkFolhapagamentoUltimoRegistroEvento;
    }
}
