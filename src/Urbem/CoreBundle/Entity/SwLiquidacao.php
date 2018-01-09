<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwLiquidacao
 */
class SwLiquidacao
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
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwLancamento
     */
    private $fkSwLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwNotaLiquidacao
     */
    private $fkSwNotaLiquidacao;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return SwLiquidacao
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
     * @return SwLiquidacao
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
     * @return SwLiquidacao
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
     * @return SwLiquidacao
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
     * @return SwLiquidacao
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
     * @return SwLiquidacao
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
     * ManyToOne (inverse side)
     * Set fkSwNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\SwNotaLiquidacao $fkSwNotaLiquidacao
     * @return SwLiquidacao
     */
    public function setFkSwNotaLiquidacao(\Urbem\CoreBundle\Entity\SwNotaLiquidacao $fkSwNotaLiquidacao)
    {
        $this->codEmpenho = $fkSwNotaLiquidacao->getCodEmpenho();
        $this->exercicio = $fkSwNotaLiquidacao->getExercicio();
        $this->codNota = $fkSwNotaLiquidacao->getCodNota();
        $this->fkSwNotaLiquidacao = $fkSwNotaLiquidacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\SwNotaLiquidacao
     */
    public function getFkSwNotaLiquidacao()
    {
        return $this->fkSwNotaLiquidacao;
    }

    /**
     * OneToOne (owning side)
     * Set SwLancamento
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento
     * @return SwLiquidacao
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
