<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwValorLancamento
 */
class SwValorLancamento
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
    private $tipo;

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
     * @var string
     */
    private $tipoValor;

    /**
     * @var integer
     */
    private $vlLancamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwLancamento
     */
    private $fkSwLancamento;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return SwValorLancamento
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
     * @return SwValorLancamento
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
     * @return SwValorLancamento
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
     * @return SwValorLancamento
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
     * Set tipoValor
     *
     * @param string $tipoValor
     * @return SwValorLancamento
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
     * @return SwValorLancamento
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
     * ManyToOne (inverse side)
     * Set fkSwLancamento
     *
     * @param \Urbem\CoreBundle\Entity\SwLancamento $fkSwLancamento
     * @return SwValorLancamento
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
     * ManyToOne (inverse side)
     * Get fkSwLancamento
     *
     * @return \Urbem\CoreBundle\Entity\SwLancamento
     */
    public function getFkSwLancamento()
    {
        return $this->fkSwLancamento;
    }
}
