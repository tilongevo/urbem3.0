<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ReajusteRegistroEvento
 */
class ReajusteRegistroEvento
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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Reajuste
     */
    private $fkFolhapagamentoReajuste;

    /**
     * ManyToOne
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
     * Set codReajuste
     *
     * @param integer $codReajuste
     * @return ReajusteRegistroEvento
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
     * @return ReajusteRegistroEvento
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
     * @return ReajusteRegistroEvento
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
     * @return ReajusteRegistroEvento
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
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoReajuste
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Reajuste $fkFolhapagamentoReajuste
     * @return ReajusteRegistroEvento
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
     * Set fkFolhapagamentoRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento $fkFolhapagamentoRegistroEvento
     * @return ReajusteRegistroEvento
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
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoRegistroEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento
     */
    public function getFkFolhapagamentoRegistroEvento()
    {
        return $this->fkFolhapagamentoRegistroEvento;
    }
}
