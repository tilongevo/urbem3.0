<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ContaBancaria
 */
class ContaBancaria
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
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $sequencia;

    /**
     * @var integer
     */
    private $codTipoAplicacao;

    /**
     * @var integer
     */
    private $codCtbAnterior;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoConta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\TipoAplicacao
     */
    private $fkTcemgTipoAplicacao;


    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return ContaBancaria
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
     * @return ContaBancaria
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
     * @return ContaBancaria
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return ContaBancaria
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set codTipoAplicacao
     *
     * @param integer $codTipoAplicacao
     * @return ContaBancaria
     */
    public function setCodTipoAplicacao($codTipoAplicacao = null)
    {
        $this->codTipoAplicacao = $codTipoAplicacao;
        return $this;
    }

    /**
     * Get codTipoAplicacao
     *
     * @return integer
     */
    public function getCodTipoAplicacao()
    {
        return $this->codTipoAplicacao;
    }

    /**
     * Set codCtbAnterior
     *
     * @param integer $codCtbAnterior
     * @return ContaBancaria
     */
    public function setCodCtbAnterior($codCtbAnterior = null)
    {
        $this->codCtbAnterior = $codCtbAnterior;
        return $this;
    }

    /**
     * Get codCtbAnterior
     *
     * @return integer
     */
    public function getCodCtbAnterior()
    {
        return $this->codCtbAnterior;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return ContaBancaria
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
     * Set fkTcemgTipoAplicacao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TipoAplicacao $fkTcemgTipoAplicacao
     * @return ContaBancaria
     */
    public function setFkTcemgTipoAplicacao(\Urbem\CoreBundle\Entity\Tcemg\TipoAplicacao $fkTcemgTipoAplicacao)
    {
        $this->codTipoAplicacao = $fkTcemgTipoAplicacao->getCodTipoAplicacao();
        $this->fkTcemgTipoAplicacao = $fkTcemgTipoAplicacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgTipoAplicacao
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TipoAplicacao
     */
    public function getFkTcemgTipoAplicacao()
    {
        return $this->fkTcemgTipoAplicacao;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return ContaBancaria
     */
    public function setFkContabilidadePlanoConta(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta)
    {
        $this->codConta = $fkContabilidadePlanoConta->getCodConta();
        $this->exercicio = $fkContabilidadePlanoConta->getExercicio();
        $this->fkContabilidadePlanoConta = $fkContabilidadePlanoConta;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadePlanoConta
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    public function getFkContabilidadePlanoConta()
    {
        return $this->fkContabilidadePlanoConta;
    }
}
