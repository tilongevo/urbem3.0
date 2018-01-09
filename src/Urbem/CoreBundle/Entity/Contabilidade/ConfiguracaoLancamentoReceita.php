<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * ConfiguracaoLancamentoReceita
 */
class ConfiguracaoLancamentoReceita
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
     * PK
     * @var integer
     */
    private $codContaReceita;

    /**
     * PK
     * @var boolean
     */
    private $estorno;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoConta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaReceita
     */
    private $fkOrcamentoContaReceita;


    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return ConfiguracaoLancamentoReceita
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
     * @return ConfiguracaoLancamentoReceita
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
     * Set codContaReceita
     *
     * @param integer $codContaReceita
     * @return ConfiguracaoLancamentoReceita
     */
    public function setCodContaReceita($codContaReceita)
    {
        $this->codContaReceita = $codContaReceita;
        return $this;
    }

    /**
     * Get codContaReceita
     *
     * @return integer
     */
    public function getCodContaReceita()
    {
        return $this->codContaReceita;
    }

    /**
     * Set estorno
     *
     * @param boolean $estorno
     * @return ConfiguracaoLancamentoReceita
     */
    public function setEstorno($estorno)
    {
        $this->estorno = $estorno;
        return $this;
    }

    /**
     * Get estorno
     *
     * @return boolean
     */
    public function getEstorno()
    {
        return $this->estorno;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return ConfiguracaoLancamentoReceita
     */
    public function setFkContabilidadePlanoConta(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta)
    {
        $this->codConta = $fkContabilidadePlanoConta->getCodConta();
        $this->exercicio = $fkContabilidadePlanoConta->getExercicio();
        $this->fkContabilidadePlanoConta = $fkContabilidadePlanoConta;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoConta
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    public function getFkContabilidadePlanoConta()
    {
        return $this->fkContabilidadePlanoConta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoContaReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita
     * @return ConfiguracaoLancamentoReceita
     */
    public function setFkOrcamentoContaReceita(\Urbem\CoreBundle\Entity\Orcamento\ContaReceita $fkOrcamentoContaReceita)
    {
        $this->exercicio = $fkOrcamentoContaReceita->getExercicio();
        $this->codContaReceita = $fkOrcamentoContaReceita->getCodConta();
        $this->fkOrcamentoContaReceita = $fkOrcamentoContaReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoContaReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaReceita
     */
    public function getFkOrcamentoContaReceita()
    {
        return $this->fkOrcamentoContaReceita;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codConta;
    }
}
