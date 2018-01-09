<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * ConfiguracaoLancamentoCredito
 */
class ConfiguracaoLancamentoCredito
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
    private $codContaDespesa;

    /**
     * PK
     * @var boolean
     */
    private $estorno;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var boolean
     */
    private $rpps;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoConta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    private $fkOrcamentoContaDespesa;


    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return ConfiguracaoLancamentoCredito
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
     * @return ConfiguracaoLancamentoCredito
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
     * Set codContaDespesa
     *
     * @param integer $codContaDespesa
     * @return ConfiguracaoLancamentoCredito
     */
    public function setCodContaDespesa($codContaDespesa)
    {
        $this->codContaDespesa = $codContaDespesa;
        return $this;
    }

    /**
     * Get codContaDespesa
     *
     * @return integer
     */
    public function getCodContaDespesa()
    {
        return $this->codContaDespesa;
    }

    /**
     * Set estorno
     *
     * @param boolean $estorno
     * @return ConfiguracaoLancamentoCredito
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
     * Set tipo
     *
     * @param string $tipo
     * @return ConfiguracaoLancamentoCredito
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set rpps
     *
     * @param boolean $rpps
     * @return ConfiguracaoLancamentoCredito
     */
    public function setRpps($rpps)
    {
        $this->rpps = $rpps;
        return $this;
    }

    /**
     * Get rpps
     *
     * @return boolean
     */
    public function getRpps()
    {
        return $this->rpps;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return ConfiguracaoLancamentoCredito
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
     * Set fkOrcamentoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa
     * @return ConfiguracaoLancamentoCredito
     */
    public function setFkOrcamentoContaDespesa(\Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa)
    {
        $this->exercicio = $fkOrcamentoContaDespesa->getExercicio();
        $this->codContaDespesa = $fkOrcamentoContaDespesa->getCodConta();
        $this->fkOrcamentoContaDespesa = $fkOrcamentoContaDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoContaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    public function getFkOrcamentoContaDespesa()
    {
        return $this->fkOrcamentoContaDespesa;
    }
}
