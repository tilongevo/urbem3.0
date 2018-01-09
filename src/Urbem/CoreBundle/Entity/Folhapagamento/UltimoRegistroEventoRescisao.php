<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * UltimoRegistroEventoRescisao
 */
class UltimoRegistroEventoRescisao
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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculado
     */
    private $fkFolhapagamentoEventoRescisaoCalculado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoRescisao
     */
    private $fkFolhapagamentoLogErroCalculoRescisao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisaoParcela
     */
    private $fkFolhapagamentoRegistroEventoRescisaoParcela;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao
     */
    private $fkFolhapagamentoRegistroEventoRescisao;

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
     * @return UltimoRegistroEventoRescisao
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
     * @return UltimoRegistroEventoRescisao
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
     * @return UltimoRegistroEventoRescisao
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
     * @return UltimoRegistroEventoRescisao
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
     * Set FolhapagamentoEventoRescisaoCalculado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculado $fkFolhapagamentoEventoRescisaoCalculado
     * @return UltimoRegistroEventoRescisao
     */
    public function setFkFolhapagamentoEventoRescisaoCalculado(\Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculado $fkFolhapagamentoEventoRescisaoCalculado)
    {
        $fkFolhapagamentoEventoRescisaoCalculado->setFkFolhapagamentoUltimoRegistroEventoRescisao($this);
        $this->fkFolhapagamentoEventoRescisaoCalculado = $fkFolhapagamentoEventoRescisaoCalculado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoEventoRescisaoCalculado
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculado
     */
    public function getFkFolhapagamentoEventoRescisaoCalculado()
    {
        return $this->fkFolhapagamentoEventoRescisaoCalculado;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoLogErroCalculoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoRescisao $fkFolhapagamentoLogErroCalculoRescisao
     * @return UltimoRegistroEventoRescisao
     */
    public function setFkFolhapagamentoLogErroCalculoRescisao(\Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoRescisao $fkFolhapagamentoLogErroCalculoRescisao)
    {
        $fkFolhapagamentoLogErroCalculoRescisao->setFkFolhapagamentoUltimoRegistroEventoRescisao($this);
        $this->fkFolhapagamentoLogErroCalculoRescisao = $fkFolhapagamentoLogErroCalculoRescisao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoLogErroCalculoRescisao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoRescisao
     */
    public function getFkFolhapagamentoLogErroCalculoRescisao()
    {
        return $this->fkFolhapagamentoLogErroCalculoRescisao;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoRegistroEventoRescisaoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisaoParcela $fkFolhapagamentoRegistroEventoRescisaoParcela
     * @return UltimoRegistroEventoRescisao
     */
    public function setFkFolhapagamentoRegistroEventoRescisaoParcela(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisaoParcela $fkFolhapagamentoRegistroEventoRescisaoParcela)
    {
        $fkFolhapagamentoRegistroEventoRescisaoParcela->setFkFolhapagamentoUltimoRegistroEventoRescisao($this);
        $this->fkFolhapagamentoRegistroEventoRescisaoParcela = $fkFolhapagamentoRegistroEventoRescisaoParcela;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoRegistroEventoRescisaoParcela
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisaoParcela
     */
    public function getFkFolhapagamentoRegistroEventoRescisaoParcela()
    {
        return $this->fkFolhapagamentoRegistroEventoRescisaoParcela;
    }

    /**
     * OneToOne (owning side)
     * Set FolhapagamentoRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao $fkFolhapagamentoRegistroEventoRescisao
     * @return UltimoRegistroEventoRescisao
     */
    public function setFkFolhapagamentoRegistroEventoRescisao(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao $fkFolhapagamentoRegistroEventoRescisao)
    {
        $this->codRegistro = $fkFolhapagamentoRegistroEventoRescisao->getCodRegistro();
        $this->timestamp = $fkFolhapagamentoRegistroEventoRescisao->getTimestamp();
        $this->desdobramento = $fkFolhapagamentoRegistroEventoRescisao->getDesdobramento();
        $this->codEvento = $fkFolhapagamentoRegistroEventoRescisao->getCodEvento();
        $this->fkFolhapagamentoRegistroEventoRescisao = $fkFolhapagamentoRegistroEventoRescisao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoRegistroEventoRescisao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao
     */
    public function getFkFolhapagamentoRegistroEventoRescisao()
    {
        return $this->fkFolhapagamentoRegistroEventoRescisao;
    }
}
