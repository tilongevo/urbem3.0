<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ConciliacaoLancamentoManual
 */
class ConciliacaoLancamentoManual
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
    private $mes;

    /**
     * PK
     * @var integer
     */
    private $sequencia;

    /**
     * @var \DateTime
     */
    private $dtLancamento;

    /**
     * @var string
     */
    private $tipoValor;

    /**
     * @var integer
     */
    private $vlLancamento;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $conciliado;

    /**
     * @var \DateTime
     */
    private $dtConciliacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Conciliacao
     */
    private $fkTesourariaConciliacao;


    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return ConciliacaoLancamentoManual
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
     * @return ConciliacaoLancamentoManual
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
     * Set mes
     *
     * @param integer $mes
     * @return ConciliacaoLancamentoManual
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return ConciliacaoLancamentoManual
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
     * Set dtLancamento
     *
     * @param \DateTime $dtLancamento
     * @return ConciliacaoLancamentoManual
     */
    public function setDtLancamento(\DateTime $dtLancamento)
    {
        $this->dtLancamento = $dtLancamento;
        return $this;
    }

    /**
     * Get dtLancamento
     *
     * @return \DateTime
     */
    public function getDtLancamento()
    {
        return $this->dtLancamento;
    }

    /**
     * Set tipoValor
     *
     * @param string $tipoValor
     * @return ConciliacaoLancamentoManual
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
     * Set vlLancamento
     *
     * @param integer $vlLancamento
     * @return ConciliacaoLancamentoManual
     */
    public function setVlLancamento($vlLancamento)
    {
        $this->vlLancamento = $vlLancamento;
        return $this;
    }

    /**
     * Get vlLancamento
     *
     * @return integer
     */
    public function getVlLancamento()
    {
        return $this->vlLancamento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ConciliacaoLancamentoManual
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set conciliado
     *
     * @param boolean $conciliado
     * @return ConciliacaoLancamentoManual
     */
    public function setConciliado($conciliado)
    {
        $this->conciliado = $conciliado;
        return $this;
    }

    /**
     * Get conciliado
     *
     * @return boolean
     */
    public function getConciliado()
    {
        return $this->conciliado;
    }

    /**
     * Set dtConciliacao
     *
     * @param \DateTime $dtConciliacao
     * @return ConciliacaoLancamentoManual
     */
    public function setDtConciliacao(\DateTime $dtConciliacao = null)
    {
        $this->dtConciliacao = $dtConciliacao;
        return $this;
    }

    /**
     * Get dtConciliacao
     *
     * @return \DateTime
     */
    public function getDtConciliacao()
    {
        return $this->dtConciliacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaConciliacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Conciliacao $fkTesourariaConciliacao
     * @return ConciliacaoLancamentoManual
     */
    public function setFkTesourariaConciliacao(\Urbem\CoreBundle\Entity\Tesouraria\Conciliacao $fkTesourariaConciliacao)
    {
        $this->codPlano = $fkTesourariaConciliacao->getCodPlano();
        $this->exercicio = $fkTesourariaConciliacao->getExercicio();
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
}
