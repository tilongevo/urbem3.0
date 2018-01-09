<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwPreEmpenhoOrdem
 */
class SwPreEmpenhoOrdem
{
    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codOrdem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    private $fkSwPreEmpenho;


    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return SwPreEmpenhoOrdem
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwPreEmpenhoOrdem
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
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return SwPreEmpenhoOrdem
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     * @return SwPreEmpenhoOrdem
     */
    public function setFkSwPreEmpenho(\Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho)
    {
        $this->codPreEmpenho = $fkSwPreEmpenho->getCodPreEmpenho();
        $this->exercicio = $fkSwPreEmpenho->getExercicio();
        $this->fkSwPreEmpenho = $fkSwPreEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    public function getFkSwPreEmpenho()
    {
        return $this->fkSwPreEmpenho;
    }
}
