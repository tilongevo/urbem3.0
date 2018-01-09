<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * LancamentoEmpenho
 */
class LancamentoEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var string
     */
    private $tipo = 'C';

    /**
     * PK
     * @var integer
     */
    private $sequencia;

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
     * @var boolean
     */
    private $estorno = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Liquidacao
     */
    private $fkContabilidadeLiquidacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Pagamento
     */
    private $fkContabilidadePagamento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PrestacaoContas
     */
    private $fkContabilidadePrestacaoContas;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Empenhamento
     */
    private $fkContabilidadeEmpenhamento;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    private $fkContabilidadeLancamento;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LancamentoEmpenho
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return LancamentoEmpenho
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return LancamentoEmpenho
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return LancamentoEmpenho
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
     * @return LancamentoEmpenho
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
     * Set estorno
     *
     * @param boolean $estorno
     * @return LancamentoEmpenho
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
     * OneToOne (inverse side)
     * Set ContabilidadeLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Liquidacao $fkContabilidadeLiquidacao
     * @return LancamentoEmpenho
     */
    public function setFkContabilidadeLiquidacao(\Urbem\CoreBundle\Entity\Contabilidade\Liquidacao $fkContabilidadeLiquidacao)
    {
        $fkContabilidadeLiquidacao->setFkContabilidadeLancamentoEmpenho($this);
        $this->fkContabilidadeLiquidacao = $fkContabilidadeLiquidacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadeLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Liquidacao
     */
    public function getFkContabilidadeLiquidacao()
    {
        return $this->fkContabilidadeLiquidacao;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadePagamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Pagamento $fkContabilidadePagamento
     * @return LancamentoEmpenho
     */
    public function setFkContabilidadePagamento(\Urbem\CoreBundle\Entity\Contabilidade\Pagamento $fkContabilidadePagamento)
    {
        $fkContabilidadePagamento->setFkContabilidadeLancamentoEmpenho($this);
        $this->fkContabilidadePagamento = $fkContabilidadePagamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadePagamento
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Pagamento
     */
    public function getFkContabilidadePagamento()
    {
        return $this->fkContabilidadePagamento;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadePrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PrestacaoContas $fkContabilidadePrestacaoContas
     * @return LancamentoEmpenho
     */
    public function setFkContabilidadePrestacaoContas(\Urbem\CoreBundle\Entity\Contabilidade\PrestacaoContas $fkContabilidadePrestacaoContas)
    {
        $fkContabilidadePrestacaoContas->setFkContabilidadeLancamentoEmpenho($this);
        $this->fkContabilidadePrestacaoContas = $fkContabilidadePrestacaoContas;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadePrestacaoContas
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PrestacaoContas
     */
    public function getFkContabilidadePrestacaoContas()
    {
        return $this->fkContabilidadePrestacaoContas;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadeEmpenhamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Empenhamento $fkContabilidadeEmpenhamento
     * @return LancamentoEmpenho
     */
    public function setFkContabilidadeEmpenhamento(\Urbem\CoreBundle\Entity\Contabilidade\Empenhamento $fkContabilidadeEmpenhamento)
    {
        $fkContabilidadeEmpenhamento->setFkContabilidadeLancamentoEmpenho($this);
        $this->fkContabilidadeEmpenhamento = $fkContabilidadeEmpenhamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadeEmpenhamento
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Empenhamento
     */
    public function getFkContabilidadeEmpenhamento()
    {
        return $this->fkContabilidadeEmpenhamento;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento
     * @return LancamentoEmpenho
     */
    public function setFkContabilidadeLancamento(\Urbem\CoreBundle\Entity\Contabilidade\Lancamento $fkContabilidadeLancamento)
    {
        $this->sequencia = $fkContabilidadeLancamento->getSequencia();
        $this->codLote = $fkContabilidadeLancamento->getCodLote();
        $this->tipo = $fkContabilidadeLancamento->getTipo();
        $this->exercicio = $fkContabilidadeLancamento->getExercicio();
        $this->codEntidade = $fkContabilidadeLancamento->getCodEntidade();
        $this->fkContabilidadeLancamento = $fkContabilidadeLancamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadeLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Lancamento
     */
    public function getFkContabilidadeLancamento()
    {
        return $this->fkContabilidadeLancamento;
    }
}
