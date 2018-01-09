<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ConciliacaoLancamentoArrecadacaoEstornada
 */
class ConciliacaoLancamentoArrecadacaoEstornada
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
    private $codPlano;

    /**
     * PK
     * @var integer
     */
    private $mes;

    /**
     * PK
     * @var integer
     */
    private $codArrecadacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampArrecadacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampEstornada;

    /**
     * PK
     * @var string
     */
    private $tipo;

    /**
     * PK
     * @var string
     */
    private $exercicioConciliacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada
     */
    private $fkTesourariaArrecadacaoEstornada;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Conciliacao
     */
    private $fkTesourariaConciliacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampArrecadacao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestampEstornada = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConciliacaoLancamentoArrecadacaoEstornada
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return ConciliacaoLancamentoArrecadacaoEstornada
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
     * Set mes
     *
     * @param integer $mes
     * @return ConciliacaoLancamentoArrecadacaoEstornada
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
     * Set codArrecadacao
     *
     * @param integer $codArrecadacao
     * @return ConciliacaoLancamentoArrecadacaoEstornada
     */
    public function setCodArrecadacao($codArrecadacao)
    {
        $this->codArrecadacao = $codArrecadacao;
        return $this;
    }

    /**
     * Get codArrecadacao
     *
     * @return integer
     */
    public function getCodArrecadacao()
    {
        return $this->codArrecadacao;
    }

    /**
     * Set timestampArrecadacao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao
     * @return ConciliacaoLancamentoArrecadacaoEstornada
     */
    public function setTimestampArrecadacao(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampArrecadacao)
    {
        $this->timestampArrecadacao = $timestampArrecadacao;
        return $this;
    }

    /**
     * Get timestampArrecadacao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampArrecadacao()
    {
        return $this->timestampArrecadacao;
    }

    /**
     * Set timestampEstornada
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampEstornada
     * @return ConciliacaoLancamentoArrecadacaoEstornada
     */
    public function setTimestampEstornada(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampEstornada)
    {
        $this->timestampEstornada = $timestampEstornada;
        return $this;
    }

    /**
     * Get timestampEstornada
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampEstornada()
    {
        return $this->timestampEstornada;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return ConciliacaoLancamentoArrecadacaoEstornada
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
     * Set exercicioConciliacao
     *
     * @param string $exercicioConciliacao
     * @return ConciliacaoLancamentoArrecadacaoEstornada
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
     * Set fkTesourariaArrecadacaoEstornada
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada
     * @return ConciliacaoLancamentoArrecadacaoEstornada
     */
    public function setFkTesourariaArrecadacaoEstornada(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada $fkTesourariaArrecadacaoEstornada)
    {
        $this->codArrecadacao = $fkTesourariaArrecadacaoEstornada->getCodArrecadacao();
        $this->exercicio = $fkTesourariaArrecadacaoEstornada->getExercicio();
        $this->timestampArrecadacao = $fkTesourariaArrecadacaoEstornada->getTimestampArrecadacao();
        $this->timestampEstornada = $fkTesourariaArrecadacaoEstornada->getTimestampEstornada();
        $this->fkTesourariaArrecadacaoEstornada = $fkTesourariaArrecadacaoEstornada;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaArrecadacaoEstornada
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoEstornada
     */
    public function getFkTesourariaArrecadacaoEstornada()
    {
        return $this->fkTesourariaArrecadacaoEstornada;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaConciliacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Conciliacao $fkTesourariaConciliacao
     * @return ConciliacaoLancamentoArrecadacaoEstornada
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
}
