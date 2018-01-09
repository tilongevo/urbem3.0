<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ReajusteRegistroEventoFerias
 */
class ReajusteRegistroEventoFerias
{
    /**
     * PK
     * @var integer
     */
    private $codReajuste;

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
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var string
     */
    private $desdobramento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Reajuste
     */
    private $fkFolhapagamentoReajuste;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias
     */
    private $fkFolhapagamentoRegistroEventoFerias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codReajuste
     *
     * @param integer $codReajuste
     * @return ReajusteRegistroEventoFerias
     */
    public function setCodReajuste($codReajuste)
    {
        $this->codReajuste = $codReajuste;
        return $this;
    }

    /**
     * Get codReajuste
     *
     * @return integer
     */
    public function getCodReajuste()
    {
        return $this->codReajuste;
    }

    /**
     * Set codRegistro
     *
     * @param integer $codRegistro
     * @return ReajusteRegistroEventoFerias
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
     * @return ReajusteRegistroEventoFerias
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return ReajusteRegistroEventoFerias
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
     * @return ReajusteRegistroEventoFerias
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
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoReajuste
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Reajuste $fkFolhapagamentoReajuste
     * @return ReajusteRegistroEventoFerias
     */
    public function setFkFolhapagamentoReajuste(\Urbem\CoreBundle\Entity\Folhapagamento\Reajuste $fkFolhapagamentoReajuste)
    {
        $this->codReajuste = $fkFolhapagamentoReajuste->getCodReajuste();
        $this->fkFolhapagamentoReajuste = $fkFolhapagamentoReajuste;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoReajuste
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Reajuste
     */
    public function getFkFolhapagamentoReajuste()
    {
        return $this->fkFolhapagamentoReajuste;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias $fkFolhapagamentoRegistroEventoFerias
     * @return ReajusteRegistroEventoFerias
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
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoRegistroEventoFerias
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias
     */
    public function getFkFolhapagamentoRegistroEventoFerias()
    {
        return $this->fkFolhapagamentoRegistroEventoFerias;
    }
}
