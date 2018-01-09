<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ReajusteRegistroEventoDecimo
 */
class ReajusteRegistroEventoDecimo
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
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo
     */
    private $fkFolhapagamentoRegistroEventoDecimo;

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
     * @return ReajusteRegistroEventoDecimo
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
     * @return ReajusteRegistroEventoDecimo
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
     * @return ReajusteRegistroEventoDecimo
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
     * @return ReajusteRegistroEventoDecimo
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
     * @return ReajusteRegistroEventoDecimo
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
     * @return ReajusteRegistroEventoDecimo
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
     * Set fkFolhapagamentoRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo $fkFolhapagamentoRegistroEventoDecimo
     * @return ReajusteRegistroEventoDecimo
     */
    public function setFkFolhapagamentoRegistroEventoDecimo(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo $fkFolhapagamentoRegistroEventoDecimo)
    {
        $this->codRegistro = $fkFolhapagamentoRegistroEventoDecimo->getCodRegistro();
        $this->timestamp = $fkFolhapagamentoRegistroEventoDecimo->getTimestamp();
        $this->desdobramento = $fkFolhapagamentoRegistroEventoDecimo->getDesdobramento();
        $this->codEvento = $fkFolhapagamentoRegistroEventoDecimo->getCodEvento();
        $this->fkFolhapagamentoRegistroEventoDecimo = $fkFolhapagamentoRegistroEventoDecimo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoRegistroEventoDecimo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo
     */
    public function getFkFolhapagamentoRegistroEventoDecimo()
    {
        return $this->fkFolhapagamentoRegistroEventoDecimo;
    }
}
