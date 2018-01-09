<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ReajusteContratoServidorSalario
 */
class ReajusteContratoServidorSalario
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
    private $codContrato;

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
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario
     */
    private $fkPessoalContratoServidorSalario;

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
     * @return ReajusteContratoServidorSalario
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
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ReajusteContratoServidorSalario
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ReajusteContratoServidorSalario
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
     * @return ReajusteContratoServidorSalario
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
     * Set fkPessoalContratoServidorSalario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario $fkPessoalContratoServidorSalario
     * @return ReajusteContratoServidorSalario
     */
    public function setFkPessoalContratoServidorSalario(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario $fkPessoalContratoServidorSalario)
    {
        $this->codContrato = $fkPessoalContratoServidorSalario->getCodContrato();
        $this->timestamp = $fkPessoalContratoServidorSalario->getTimestamp();
        $this->fkPessoalContratoServidorSalario = $fkPessoalContratoServidorSalario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoServidorSalario
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSalario
     */
    public function getFkPessoalContratoServidorSalario()
    {
        return $this->fkPessoalContratoServidorSalario;
    }
}
