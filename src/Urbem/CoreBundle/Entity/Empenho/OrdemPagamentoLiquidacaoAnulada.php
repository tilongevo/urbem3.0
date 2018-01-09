<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * OrdemPagamentoLiquidacaoAnulada
 */
class OrdemPagamentoLiquidacaoAnulada
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
    private $codOrdem;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var string
     */
    private $exercicioLiquidacao;

    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var integer
     */
    private $vlAnulado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAnulada
     */
    private $fkEmpenhoOrdemPagamentoAnulada;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao
     */
    private $fkEmpenhoPagamentoLiquidacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OrdemPagamentoLiquidacaoAnulada
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
     * @return OrdemPagamentoLiquidacaoAnulada
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
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return OrdemPagamentoLiquidacaoAnulada
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return OrdemPagamentoLiquidacaoAnulada
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
     * Set exercicioLiquidacao
     *
     * @param string $exercicioLiquidacao
     * @return OrdemPagamentoLiquidacaoAnulada
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
     * @return OrdemPagamentoLiquidacaoAnulada
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
     * Set vlAnulado
     *
     * @param integer $vlAnulado
     * @return OrdemPagamentoLiquidacaoAnulada
     */
    public function setVlAnulado($vlAnulado)
    {
        $this->vlAnulado = $vlAnulado;
        return $this;
    }

    /**
     * Get vlAnulado
     *
     * @return integer
     */
    public function getVlAnulado()
    {
        return $this->vlAnulado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoOrdemPagamentoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAnulada $fkEmpenhoOrdemPagamentoAnulada
     * @return OrdemPagamentoLiquidacaoAnulada
     */
    public function setFkEmpenhoOrdemPagamentoAnulada(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAnulada $fkEmpenhoOrdemPagamentoAnulada)
    {
        $this->codOrdem = $fkEmpenhoOrdemPagamentoAnulada->getCodOrdem();
        $this->exercicio = $fkEmpenhoOrdemPagamentoAnulada->getExercicio();
        $this->codEntidade = $fkEmpenhoOrdemPagamentoAnulada->getCodEntidade();
        $this->timestamp = $fkEmpenhoOrdemPagamentoAnulada->getTimestamp();
        $this->fkEmpenhoOrdemPagamentoAnulada = $fkEmpenhoOrdemPagamentoAnulada;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoOrdemPagamentoAnulada
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAnulada
     */
    public function getFkEmpenhoOrdemPagamentoAnulada()
    {
        return $this->fkEmpenhoOrdemPagamentoAnulada;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoPagamentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao $fkEmpenhoPagamentoLiquidacao
     * @return OrdemPagamentoLiquidacaoAnulada
     */
    public function setFkEmpenhoPagamentoLiquidacao(\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao $fkEmpenhoPagamentoLiquidacao)
    {
        $this->codOrdem = $fkEmpenhoPagamentoLiquidacao->getCodOrdem();
        $this->exercicio = $fkEmpenhoPagamentoLiquidacao->getExercicio();
        $this->codEntidade = $fkEmpenhoPagamentoLiquidacao->getCodEntidade();
        $this->exercicioLiquidacao = $fkEmpenhoPagamentoLiquidacao->getExercicioLiquidacao();
        $this->codNota = $fkEmpenhoPagamentoLiquidacao->getCodNota();
        $this->fkEmpenhoPagamentoLiquidacao = $fkEmpenhoPagamentoLiquidacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoPagamentoLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao
     */
    public function getFkEmpenhoPagamentoLiquidacao()
    {
        return $this->fkEmpenhoPagamentoLiquidacao;
    }
}
