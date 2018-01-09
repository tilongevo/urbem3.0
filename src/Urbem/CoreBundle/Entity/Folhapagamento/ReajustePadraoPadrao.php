<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ReajustePadraoPadrao
 */
class ReajustePadraoPadrao
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
    private $codPadrao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Reajuste
     */
    private $fkFolhapagamentoReajuste;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao
     */
    private $fkFolhapagamentoPadraoPadrao;

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
     * @return ReajustePadraoPadrao
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
     * Set codPadrao
     *
     * @param integer $codPadrao
     * @return ReajustePadraoPadrao
     */
    public function setCodPadrao($codPadrao)
    {
        $this->codPadrao = $codPadrao;
        return $this;
    }

    /**
     * Get codPadrao
     *
     * @return integer
     */
    public function getCodPadrao()
    {
        return $this->codPadrao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ReajustePadraoPadrao
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
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoReajuste
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Reajuste $fkFolhapagamentoReajuste
     * @return ReajustePadraoPadrao
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
     * Set fkFolhapagamentoPadraoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao $fkFolhapagamentoPadraoPadrao
     * @return ReajustePadraoPadrao
     */
    public function setFkFolhapagamentoPadraoPadrao(\Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao $fkFolhapagamentoPadraoPadrao)
    {
        $this->codPadrao = $fkFolhapagamentoPadraoPadrao->getCodPadrao();
        $this->timestamp = $fkFolhapagamentoPadraoPadrao->getTimestamp();
        $this->fkFolhapagamentoPadraoPadrao = $fkFolhapagamentoPadraoPadrao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoPadraoPadrao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao
     */
    public function getFkFolhapagamentoPadraoPadrao()
    {
        return $this->fkFolhapagamentoPadraoPadrao;
    }
}
