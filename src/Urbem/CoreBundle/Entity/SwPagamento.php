<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwPagamento
 */
class SwPagamento
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
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var integer
     */
    private $codNota;

    /**
     * @var integer
     */
    private $codOrdem;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwLancamento
     */
    private $fkSwLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwPagamentoLiquidacao
     */
    private $fkSwPagamentoLiquidacao;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return SwPagamento
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
     * @return SwPagamento
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
     * @return SwPagamento
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
     * @return SwPagamento
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
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return SwPagamento
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return SwPagamento
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
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return SwPagamento
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
     * ManyToOne (inverse side)
     * Set fkSwPagamentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\SwPagamentoLiquidacao $fkSwPagamentoLiquidacao
     * @return SwPagamento
     */
    public function setFkSwPagamentoLiquidacao(\Urbem\CoreBundle\Entity\SwPagamentoLiquidacao $fkSwPagamentoLiquidacao)
    {
        $this->codEmpenho = $fkSwPagamentoLiquidacao->getCodEmpenho();
        $this->exercicio = $fkSwPagamentoLiquidacao->getExercicio();
        $this->codNota = $fkSwPagamentoLiquidacao->getCodNota();
        $this->codOrdem = $fkSwPagamentoLiquidacao->getCodOrdem();
        $this->fkSwPagamentoLiquidacao = $fkSwPagamentoLiquidacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwPagamentoLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\SwPagamentoLiquidacao
     */
    public function getFkSwPagamentoLiquidacao()
    {
        return $this->fkSwPagamentoLiquidacao;
    }

    /**
     * OneToOne (owning side)
     * Set SwLancamento
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento
     * @return SwPagamento
     */
    public function setFkSwLancamento(\Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento)
    {
        $this->sequencia = $fkSwLancamento->getSequencia();
        $this->codLote = $fkSwLancamento->getCodLote();
        $this->tipo = $fkSwLancamento->getTipo();
        $this->exercicio = $fkSwLancamento->getExercicio();
        $this->fkSwLancamento = $fkSwLancamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwLancamento
     *
     * @return \Urbem\CoreBundle\Entity\SwLancamento
     */
    public function getFkSwLancamento()
    {
        return $this->fkSwLancamento;
    }
}
