<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwValorInflator
 */
class SwValorInflator
{
    /**
     * PK
     * @var integer
     */
    private $codInflator;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtValor;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwInflator
     */
    private $fkSwInflator;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtValor = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codInflator
     *
     * @param integer $codInflator
     * @return SwValorInflator
     */
    public function setCodInflator($codInflator)
    {
        $this->codInflator = $codInflator;
        return $this;
    }

    /**
     * Get codInflator
     *
     * @return integer
     */
    public function getCodInflator()
    {
        return $this->codInflator;
    }

    /**
     * Set dtValor
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtValor
     * @return SwValorInflator
     */
    public function setDtValor(\Urbem\CoreBundle\Helper\DatePK $dtValor)
    {
        $this->dtValor = $dtValor;
        return $this;
    }

    /**
     * Get dtValor
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtValor()
    {
        return $this->dtValor;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return SwValorInflator
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

    /**
     * ManyToOne (inverse side)
     * Set fkSwInflator
     *
     * @param \Urbem\CoreBundle\Entity\SwInflator $fkSwInflator
     * @return SwValorInflator
     */
    public function setFkSwInflator(\Urbem\CoreBundle\Entity\SwInflator $fkSwInflator)
    {
        $this->codInflator = $fkSwInflator->getCodInflator();
        $this->fkSwInflator = $fkSwInflator;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwInflator
     *
     * @return \Urbem\CoreBundle\Entity\SwInflator
     */
    public function getFkSwInflator()
    {
        return $this->fkSwInflator;
    }
}
