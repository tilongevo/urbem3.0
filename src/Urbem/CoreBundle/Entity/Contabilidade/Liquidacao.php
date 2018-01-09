<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Liquidacao
 */
class Liquidacao
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
    private $sequencia;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codNota;

    /**
     * @var string
     */
    private $exercicioLiquidacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho
     */
    private $fkContabilidadeLancamentoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacao;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Liquidacao
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return Liquidacao
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
     * Set tipo
     *
     * @param string $tipo
     * @return Liquidacao
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
     * Set codLote
     *
     * @param integer $codLote
     * @return Liquidacao
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Liquidacao
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
     * Set codNota
     *
     * @param integer $codNota
     * @return Liquidacao
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
     * Set exercicioLiquidacao
     *
     * @param string $exercicioLiquidacao
     * @return Liquidacao
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
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return Liquidacao
     */
    public function setFkEmpenhoNotaLiquidacao(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        $this->exercicioLiquidacao = $fkEmpenhoNotaLiquidacao->getExercicio();
        $this->codNota = $fkEmpenhoNotaLiquidacao->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacao->getCodEntidade();
        $this->fkEmpenhoNotaLiquidacao = $fkEmpenhoNotaLiquidacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    public function getFkEmpenhoNotaLiquidacao()
    {
        return $this->fkEmpenhoNotaLiquidacao;
    }

    /**
     * OneToOne (owning side)
     * Set ContabilidadeLancamentoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho $fkContabilidadeLancamentoEmpenho
     * @return Liquidacao
     */
    public function setFkContabilidadeLancamentoEmpenho(\Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho $fkContabilidadeLancamentoEmpenho)
    {
        $this->codLote = $fkContabilidadeLancamentoEmpenho->getCodLote();
        $this->tipo = $fkContabilidadeLancamentoEmpenho->getTipo();
        $this->sequencia = $fkContabilidadeLancamentoEmpenho->getSequencia();
        $this->exercicio = $fkContabilidadeLancamentoEmpenho->getExercicio();
        $this->codEntidade = $fkContabilidadeLancamentoEmpenho->getCodEntidade();
        $this->fkContabilidadeLancamentoEmpenho = $fkContabilidadeLancamentoEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkContabilidadeLancamentoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho
     */
    public function getFkContabilidadeLancamentoEmpenho()
    {
        return $this->fkContabilidadeLancamentoEmpenho;
    }
}
