<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * ContaLancamentoRp
 */
class ContaLancamentoRp
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codTipoConta;

    /**
     * @var integer
     */
    private $codPlano;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\TipoContaLancamentoRp
     */
    private $fkContabilidadeTipoContaLancamentoRp;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ContaLancamentoRp
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ContaLancamentoRp
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codTipoConta
     *
     * @param integer $codTipoConta
     * @return ContaLancamentoRp
     */
    public function setCodTipoConta($codTipoConta)
    {
        $this->codTipoConta = $codTipoConta;
        return $this;
    }

    /**
     * Get codTipoConta
     *
     * @return integer
     */
    public function getCodTipoConta()
    {
        return $this->codTipoConta;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return ContaLancamentoRp
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return ContaLancamentoRp
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return ContaLancamentoRp
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeTipoContaLancamentoRp
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\TipoContaLancamentoRp $fkContabilidadeTipoContaLancamentoRp
     * @return ContaLancamentoRp
     */
    public function setFkContabilidadeTipoContaLancamentoRp(\Urbem\CoreBundle\Entity\Contabilidade\TipoContaLancamentoRp $fkContabilidadeTipoContaLancamentoRp)
    {
        $this->codTipoConta = $fkContabilidadeTipoContaLancamentoRp->getCodTipoConta();
        $this->fkContabilidadeTipoContaLancamentoRp = $fkContabilidadeTipoContaLancamentoRp;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeTipoContaLancamentoRp
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\TipoContaLancamentoRp
     */
    public function getFkContabilidadeTipoContaLancamentoRp()
    {
        return $this->fkContabilidadeTipoContaLancamentoRp;
    }
}
