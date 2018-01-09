<?php
 
namespace Urbem\CoreBundle\Entity\Tcems;

/**
 * ReceitaCorrenteLiquida
 */
class ReceitaCorrenteLiquida
{
    /**
     * PK
     * @var integer
     */
    private $mes;

    /**
     * PK
     * @var string
     */
    private $ano;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $valor;


    /**
     * Set mes
     *
     * @param integer $mes
     * @return ReceitaCorrenteLiquida
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
     * Set ano
     *
     * @param string $ano
     * @return ReceitaCorrenteLiquida
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ReceitaCorrenteLiquida
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
     * Set valor
     *
     * @param integer $valor
     * @return ReceitaCorrenteLiquida
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }
}
