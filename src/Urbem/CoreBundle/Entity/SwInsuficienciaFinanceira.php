<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwInsuficienciaFinanceira
 */
class SwInsuficienciaFinanceira
{
    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $vlInsuficiencia;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwEmpenho
     */
    private $fkSwEmpenho;


    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return SwInsuficienciaFinanceira
     */
    public function setCodEmpenho($codEmpenho)
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwInsuficienciaFinanceira
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
     * Set vlInsuficiencia
     *
     * @param integer $vlInsuficiencia
     * @return SwInsuficienciaFinanceira
     */
    public function setVlInsuficiencia($vlInsuficiencia)
    {
        $this->vlInsuficiencia = $vlInsuficiencia;
        return $this;
    }

    /**
     * Get vlInsuficiencia
     *
     * @return integer
     */
    public function getVlInsuficiencia()
    {
        return $this->vlInsuficiencia;
    }

    /**
     * OneToOne (owning side)
     * Set SwEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenho $fkSwEmpenho
     * @return SwInsuficienciaFinanceira
     */
    public function setFkSwEmpenho(\Urbem\CoreBundle\Entity\SwEmpenho $fkSwEmpenho)
    {
        $this->exercicio = $fkSwEmpenho->getExercicio();
        $this->codEmpenho = $fkSwEmpenho->getCodEmpenho();
        $this->fkSwEmpenho = $fkSwEmpenho;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwEmpenho
     */
    public function getFkSwEmpenho()
    {
        return $this->fkSwEmpenho;
    }
}
