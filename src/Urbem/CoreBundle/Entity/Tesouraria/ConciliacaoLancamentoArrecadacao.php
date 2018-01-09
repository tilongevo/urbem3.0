<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ConciliacaoLancamentoArrecadacao
 */
class ConciliacaoLancamentoArrecadacao
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
    private $codArrecadacao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampArrecadacao;

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
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Conciliacao
     */
    private $fkTesourariaConciliacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    private $fkTesourariaArrecadacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampArrecadacao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return ConciliacaoLancamentoArrecadacao
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
     * @return ConciliacaoLancamentoArrecadacao
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
     * @return ConciliacaoLancamentoArrecadacao
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
     * @return ConciliacaoLancamentoArrecadacao
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
     * @return ConciliacaoLancamentoArrecadacao
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
     * Set tipo
     *
     * @param string $tipo
     * @return ConciliacaoLancamentoArrecadacao
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
     * @return ConciliacaoLancamentoArrecadacao
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
     * @return ConciliacaoLancamentoArrecadacao
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
     * Set fkTesourariaArrecadacao
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao
     * @return ConciliacaoLancamentoArrecadacao
     */
    public function setFkTesourariaArrecadacao(\Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao $fkTesourariaArrecadacao)
    {
        $this->codArrecadacao = $fkTesourariaArrecadacao->getCodArrecadacao();
        $this->exercicio = $fkTesourariaArrecadacao->getExercicio();
        $this->timestampArrecadacao = $fkTesourariaArrecadacao->getTimestampArrecadacao();
        $this->fkTesourariaArrecadacao = $fkTesourariaArrecadacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaArrecadacao
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao
     */
    public function getFkTesourariaArrecadacao()
    {
        return $this->fkTesourariaArrecadacao;
    }
}
