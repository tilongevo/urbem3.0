<?php
 
namespace Urbem\CoreBundle\Entity\Tcerj;

/**
 * ContaDespesa
 */
class ContaDespesa
{
    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $codEstruturalTce;

    /**
     * @var boolean
     */
    private $lancamento = true;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    private $fkOrcamentoContaDespesa;


    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return ContaDespesa
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContaDespesa
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codEstruturalTce
     *
     * @param string $codEstruturalTce
     * @return ContaDespesa
     */
    public function setCodEstruturalTce($codEstruturalTce)
    {
        $this->codEstruturalTce = $codEstruturalTce;
        return $this;
    }

    /**
     * Get codEstruturalTce
     *
     * @return string
     */
    public function getCodEstruturalTce()
    {
        return $this->codEstruturalTce;
    }

    /**
     * Set lancamento
     *
     * @param boolean $lancamento
     * @return ContaDespesa
     */
    public function setLancamento($lancamento)
    {
        $this->lancamento = $lancamento;
        return $this;
    }

    /**
     * Get lancamento
     *
     * @return boolean
     */
    public function getLancamento()
    {
        return $this->lancamento;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa
     * @return ContaDespesa
     */
    public function setFkOrcamentoContaDespesa(\Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa)
    {
        $this->exercicio = $fkOrcamentoContaDespesa->getExercicio();
        $this->codConta = $fkOrcamentoContaDespesa->getCodConta();
        $this->fkOrcamentoContaDespesa = $fkOrcamentoContaDespesa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoContaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    public function getFkOrcamentoContaDespesa()
    {
        return $this->fkOrcamentoContaDespesa;
    }
}
