<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * CorrigePlanoAnalitica
 */
class CorrigePlanoAnalitica
{
    /**
     * PK
     * @var integer
     */
    private $codPlano;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codConta;

    /**
     * @var string
     */
    private $naturezaSaldo;


    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return CorrigePlanoAnalitica
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
     * @return CorrigePlanoAnalitica
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
     * Set codConta
     *
     * @param integer $codConta
     * @return CorrigePlanoAnalitica
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set naturezaSaldo
     *
     * @param string $naturezaSaldo
     * @return CorrigePlanoAnalitica
     */
    public function setNaturezaSaldo($naturezaSaldo)
    {
        $this->naturezaSaldo = $naturezaSaldo;
        return $this;
    }

    /**
     * Get naturezaSaldo
     *
     * @return string
     */
    public function getNaturezaSaldo()
    {
        return $this->naturezaSaldo;
    }
}
