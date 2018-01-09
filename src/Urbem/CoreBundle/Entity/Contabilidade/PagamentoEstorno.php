<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * PagamentoEstorno
 */
class PagamentoEstorno
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
     * @var string
     */
    private $exercicioLiquidacao;

    /**
     * @var integer
     */
    private $codNota;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $timestampAnulada;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\Pagamento
     */
    private $fkContabilidadePagamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada
     */
    private $fkEmpenhoNotaLiquidacaoPagaAnulada;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PagamentoEstorno
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
     * @return PagamentoEstorno
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
     * Set codLote
     *
     * @param integer $codLote
     * @return PagamentoEstorno
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
     * @return PagamentoEstorno
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
     * @return PagamentoEstorno
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
     * Set exercicioLiquidacao
     *
     * @param string $exercicioLiquidacao
     * @return PagamentoEstorno
     */
    public function setExercicioLiquidacao($exercicioLiquidacao)
    {
        $this->exercicioLiquidacao = $exercicioLiquidacao;
        return $this;
    }

    /**
     * Get exercicioLiquidacao
     *
     * @return string
     */
    public function getExercicioLiquidacao()
    {
        return $this->exercicioLiquidacao;
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return PagamentoEstorno
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PagamentoEstorno
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
     * Set timestampAnulada
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAnulada
     * @return PagamentoEstorno
     */
    public function setTimestampAnulada(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAnulada)
    {
        $this->timestampAnulada = $timestampAnulada;
        return $this;
    }

    /**
     * Get timestampAnulada
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAnulada()
    {
        return $this->timestampAnulada;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacaoPagaAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada $fkEmpenhoNotaLiquidacaoPagaAnulada
     * @return PagamentoEstorno
     */
    public function setFkEmpenhoNotaLiquidacaoPagaAnulada(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada $fkEmpenhoNotaLiquidacaoPagaAnulada)
    {
        $this->exercicioLiquidacao = $fkEmpenhoNotaLiquidacaoPagaAnulada->getExercicio();
        $this->codNota = $fkEmpenhoNotaLiquidacaoPagaAnulada->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacaoPagaAnulada->getCodEntidade();
        $this->timestamp = $fkEmpenhoNotaLiquidacaoPagaAnulada->getTimestamp();
        $this->timestampAnulada = $fkEmpenhoNotaLiquidacaoPagaAnulada->getTimestampAnulada();
        $this->fkEmpenhoNotaLiquidacaoPagaAnulada = $fkEmpenhoNotaLiquidacaoPagaAnulada;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacaoPagaAnulada
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada
     */
    public function getFkEmpenhoNotaLiquidacaoPagaAnulada()
    {
        return $this->fkEmpenhoNotaLiquidacaoPagaAnulada;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadePagamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Pagamento $fkContabilidadePagamento
     * @return PagamentoEstorno
     */
    public function setFkContabilidadePagamento(\Urbem\CoreBundle\Entity\Contabilidade\Pagamento $fkContabilidadePagamento)
    {
        $this->exercicio = $fkContabilidadePagamento->getExercicio();
        $this->sequencia = $fkContabilidadePagamento->getSequencia();
        $this->tipo = $fkContabilidadePagamento->getTipo();
        $this->codLote = $fkContabilidadePagamento->getCodLote();
        $this->codEntidade = $fkContabilidadePagamento->getCodEntidade();
        $this->fkContabilidadePagamento = $fkContabilidadePagamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadePagamento
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\Pagamento
     */
    public function getFkContabilidadePagamento()
    {
        return $this->fkContabilidadePagamento;
    }
}
