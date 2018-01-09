<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwValorAtributoPreEmpenho
 */
class SwValorAtributoPreEmpenho
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
    private $codAtributo;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    private $fkSwPreEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAtributoPreEmpenho
     */
    private $fkSwAtributoPreEmpenho;


    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return SwValorAtributoPreEmpenho
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
     * @return SwValorAtributoPreEmpenho
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
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwValorAtributoPreEmpenho
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return SwValorAtributoPreEmpenho
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
     * ManyToOne (inverse side)
     * Set fkSwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     * @return SwValorAtributoPreEmpenho
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

    /**
     * ManyToOne (inverse side)
     * Set fkSwAtributoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwAtributoPreEmpenho $fkSwAtributoPreEmpenho
     * @return SwValorAtributoPreEmpenho
     */
    public function setFkSwAtributoPreEmpenho(\Urbem\CoreBundle\Entity\SwAtributoPreEmpenho $fkSwAtributoPreEmpenho)
    {
        $this->codAtributo = $fkSwAtributoPreEmpenho->getCodAtributo();
        $this->exercicio = $fkSwAtributoPreEmpenho->getExercicio();
        $this->fkSwAtributoPreEmpenho = $fkSwAtributoPreEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAtributoPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwAtributoPreEmpenho
     */
    public function getFkSwAtributoPreEmpenho()
    {
        return $this->fkSwAtributoPreEmpenho;
    }
}
