<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * CorrigePlanoRecurso
 */
class CorrigePlanoRecurso
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
    private $codRecurso;


    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return CorrigePlanoRecurso
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
     * @return CorrigePlanoRecurso
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return CorrigePlanoRecurso
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }
}
