<?php
 
namespace Urbem\CoreBundle\Entity\Tcerj;

/**
 * ContaReceita
 */
class ContaReceita
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
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaReceita
     */
    private $fkOrcamentoContaReceita;


    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return ContaReceita
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
     * @return ContaReceita
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
     * @return ContaReceita
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
     * @return ContaReceita
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
     * Set OrcamentoContaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita
     * @return ContaReceita
     */
    public function setFkOrcamentoContaReceita(\Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita)
    {
        $this->exercicio = $fkOrcamentoContaReceita->getExercicio();
        $this->codConta = $fkOrcamentoContaReceita->getCodConta();
        $this->fkOrcamentoContaReceita = $fkOrcamentoContaReceita;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoContaReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaReceita
     */
    public function getFkOrcamentoContaReceita()
    {
        return $this->fkOrcamentoContaReceita;
    }
}
