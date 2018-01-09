<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * ConfiguracaoContabilidade
 */
class ConfiguracaoContabilidade
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var string
     */
    private $parametro;

    /**
     * @var string
     */
    private $valor;

    /**
     * @var boolean
     */
    private $fixo = false;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoContabilidade
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
     * Set parametro
     *
     * @param string $parametro
     * @return ConfiguracaoContabilidade
     */
    public function setParametro($parametro)
    {
        $this->parametro = $parametro;
        return $this;
    }

    /**
     * Get parametro
     *
     * @return string
     */
    public function getParametro()
    {
        return $this->parametro;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return ConfiguracaoContabilidade
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set fixo
     *
     * @param boolean $fixo
     * @return ConfiguracaoContabilidade
     */
    public function setFixo($fixo)
    {
        $this->fixo = $fixo;
        return $this;
    }

    /**
     * Get fixo
     *
     * @return boolean
     */
    public function getFixo()
    {
        return $this->fixo;
    }
}
