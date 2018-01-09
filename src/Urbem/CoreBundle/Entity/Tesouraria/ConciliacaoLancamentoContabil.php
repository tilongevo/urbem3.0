<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ConciliacaoLancamentoContabil
 */
class ConciliacaoLancamentoContabil
{
    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $tipoValor;

    /**
     * PK
     * @var integer
     */
    private $mes;

    /**
     * PK
     * @var string
     */
    private $exercicioConciliacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Conciliacao
     */
    private $fkTesourariaConciliacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento
     */
    private $fkContabilidadeValorLancamento;


    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return ConciliacaoLancamentoContabil
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConciliacaoLancamentoContabil
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
     * Set codLote
     *
     * @param integer $codLote
     * @return ConciliacaoLancamentoContabil
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
     * @return ConciliacaoLancamentoContabil
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
     * @return ConciliacaoLancamentoContabil
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ConciliacaoLancamentoContabil
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
     * Set tipoValor
     *
     * @param string $tipoValor
     * @return ConciliacaoLancamentoContabil
     */
    public function setTipoValor($tipoValor)
    {
        $this->tipoValor = $tipoValor;
        return $this;
    }

    /**
     * Get tipoValor
     *
     * @return string
     */
    public function getTipoValor()
    {
        return $this->tipoValor;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     * @return ConciliacaoLancamentoContabil
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set exercicioConciliacao
     *
     * @param string $exercicioConciliacao
     * @return ConciliacaoLancamentoContabil
     */
    public function setExercicioConciliacao($exercicioConciliacao)
    {
        $this->exercicioConciliacao = $exercicioConciliacao;
        return $this;
    }

    /**
     * Get exercicioConciliacao
     *
     * @return string
     */
    public function getExercicioConciliacao()
    {
        return $this->exercicioConciliacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaConciliacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Conciliacao $fkTesourariaConciliacao
     * @return ConciliacaoLancamentoContabil
     */
    public function setFkTesourariaConciliacao(\Urbem\CoreBundle\Entity\Tesouraria\Conciliacao $fkTesourariaConciliacao)
    {
        $this->codPlano = $fkTesourariaConciliacao->getCodPlano();
        $this->exercicioConciliacao = $fkTesourariaConciliacao->getExercicio();
        $this->mes = $fkTesourariaConciliacao->getMes();
        $this->fkTesourariaConciliacao = $fkTesourariaConciliacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaConciliacao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Conciliacao
     */
    public function getFkTesourariaConciliacao()
    {
        return $this->fkTesourariaConciliacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadeValorLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento $fkContabilidadeValorLancamento
     * @return ConciliacaoLancamentoContabil
     */
    public function setFkContabilidadeValorLancamento(\Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento $fkContabilidadeValorLancamento)
    {
        $this->codLote = $fkContabilidadeValorLancamento->getCodLote();
        $this->tipo = $fkContabilidadeValorLancamento->getTipo();
        $this->sequencia = $fkContabilidadeValorLancamento->getSequencia();
        $this->exercicio = $fkContabilidadeValorLancamento->getExercicio();
        $this->tipoValor = $fkContabilidadeValorLancamento->getTipoValor();
        $this->codEntidade = $fkContabilidadeValorLancamento->getCodEntidade();
        $this->fkContabilidadeValorLancamento = $fkContabilidadeValorLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadeValorLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento
     */
    public function getFkContabilidadeValorLancamento()
    {
        return $this->fkContabilidadeValorLancamento;
    }
}
