<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * RegistroEventoRescisaoParcela
 */
class RegistroEventoRescisaoParcela
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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao
     */
    private $fkFolhapagamentoUltimoRegistroEventoRescisao;

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
     * @return RegistroEventoRescisaoParcela
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
     * @return RegistroEventoRescisaoParcela
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
     * @return RegistroEventoRescisaoParcela
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return RegistroEventoRescisaoParcela
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
     * @return RegistroEventoRescisaoParcela
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
     * Set FolhapagamentoUltimoRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao $fkFolhapagamentoUltimoRegistroEventoRescisao
     * @return RegistroEventoRescisaoParcela
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
