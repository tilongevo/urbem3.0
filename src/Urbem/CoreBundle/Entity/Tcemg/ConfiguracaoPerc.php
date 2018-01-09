<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ConfiguracaoPerc
 */
class ConfiguracaoPerc
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $planejamentoAnual;

    /**
     * @var integer
     */
    private $porcentualAnual;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoPerc
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
     * Set planejamentoAnual
     *
     * @param integer $planejamentoAnual
     * @return ConfiguracaoPerc
     */
    public function setPlanejamentoAnual($planejamentoAnual)
    {
        $this->planejamentoAnual = $planejamentoAnual;
        return $this;
    }

    /**
     * Get planejamentoAnual
     *
     * @return integer
     */
    public function getPlanejamentoAnual()
    {
        return $this->planejamentoAnual;
    }

    /**
     * Set porcentualAnual
     *
     * @param integer $porcentualAnual
     * @return ConfiguracaoPerc
     */
    public function setPorcentualAnual($porcentualAnual = null)
    {
        $this->porcentualAnual = $porcentualAnual;
        return $this;
    }

    /**
     * Get porcentualAnual
     *
     * @return integer
     */
    public function getPorcentualAnual()
    {
        return $this->porcentualAnual;
    }
}
