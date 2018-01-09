<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Consistencia2
 */
class Consistencia2
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var string
     */
    private $dtEmpenho;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $dtLiquidacao;

    /**
     * @var string
     */
    private $exercicioLiquidacao;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Consistencia2
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
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return Consistencia2
     */
    public function setCodEmpenho($codEmpenho = null)
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
     * Set dtEmpenho
     *
     * @param string $dtEmpenho
     * @return Consistencia2
     */
    public function setDtEmpenho($dtEmpenho = null)
    {
        $this->dtEmpenho = $dtEmpenho;
        return $this;
    }

    /**
     * Get dtEmpenho
     *
     * @return string
     */
    public function getDtEmpenho()
    {
        return $this->dtEmpenho;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Consistencia2
     */
    public function setExercicio($exercicio = null)
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
     * Set dtLiquidacao
     *
     * @param string $dtLiquidacao
     * @return Consistencia2
     */
    public function setDtLiquidacao($dtLiquidacao = null)
    {
        $this->dtLiquidacao = $dtLiquidacao;
        return $this;
    }

    /**
     * Get dtLiquidacao
     *
     * @return string
     */
    public function getDtLiquidacao()
    {
        return $this->dtLiquidacao;
    }

    /**
     * Set exercicioLiquidacao
     *
     * @param string $exercicioLiquidacao
     * @return Consistencia2
     */
    public function setExercicioLiquidacao($exercicioLiquidacao = null)
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
}
