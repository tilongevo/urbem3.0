<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwInflator
 */
class SwInflator
{
    /**
     * PK
     * @var integer
     */
    private $codInflator;

    /**
     * @var string
     */
    private $nomInflator;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $numDecimais;

    /**
     * @var integer
     */
    private $formulaCalculo;

    /**
     * @var string
     */
    private $periodoCorrecao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwValorInflator
     */
    private $fkSwValorInflatores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCalculoInflator
     */
    private $fkSwCalculoInflator;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwValorInflatores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codInflator
     *
     * @param integer $codInflator
     * @return SwInflator
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
     * Set nomInflator
     *
     * @param string $nomInflator
     * @return SwInflator
     */
    public function setNomInflator($nomInflator)
    {
        $this->nomInflator = $nomInflator;
        return $this;
    }

    /**
     * Get nomInflator
     *
     * @return string
     */
    public function getNomInflator()
    {
        return $this->nomInflator;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return SwInflator
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set numDecimais
     *
     * @param integer $numDecimais
     * @return SwInflator
     */
    public function setNumDecimais($numDecimais)
    {
        $this->numDecimais = $numDecimais;
        return $this;
    }

    /**
     * Get numDecimais
     *
     * @return integer
     */
    public function getNumDecimais()
    {
        return $this->numDecimais;
    }

    /**
     * Set formulaCalculo
     *
     * @param integer $formulaCalculo
     * @return SwInflator
     */
    public function setFormulaCalculo($formulaCalculo)
    {
        $this->formulaCalculo = $formulaCalculo;
        return $this;
    }

    /**
     * Get formulaCalculo
     *
     * @return integer
     */
    public function getFormulaCalculo()
    {
        return $this->formulaCalculo;
    }

    /**
     * Set periodoCorrecao
     *
     * @param string $periodoCorrecao
     * @return SwInflator
     */
    public function setPeriodoCorrecao($periodoCorrecao)
    {
        $this->periodoCorrecao = $periodoCorrecao;
        return $this;
    }

    /**
     * Get periodoCorrecao
     *
     * @return string
     */
    public function getPeriodoCorrecao()
    {
        return $this->periodoCorrecao;
    }

    /**
     * OneToMany (owning side)
     * Add SwValorInflator
     *
     * @param \Urbem\CoreBundle\Entity\SwValorInflator $fkSwValorInflator
     * @return SwInflator
     */
    public function addFkSwValorInflatores(\Urbem\CoreBundle\Entity\SwValorInflator $fkSwValorInflator)
    {
        if (false === $this->fkSwValorInflatores->contains($fkSwValorInflator)) {
            $fkSwValorInflator->setFkSwInflator($this);
            $this->fkSwValorInflatores->add($fkSwValorInflator);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwValorInflator
     *
     * @param \Urbem\CoreBundle\Entity\SwValorInflator $fkSwValorInflator
     */
    public function removeFkSwValorInflatores(\Urbem\CoreBundle\Entity\SwValorInflator $fkSwValorInflator)
    {
        $this->fkSwValorInflatores->removeElement($fkSwValorInflator);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwValorInflatores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwValorInflator
     */
    public function getFkSwValorInflatores()
    {
        return $this->fkSwValorInflatores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCalculoInflator
     *
     * @param \Urbem\CoreBundle\Entity\SwCalculoInflator $fkSwCalculoInflator
     * @return SwInflator
     */
    public function setFkSwCalculoInflator(\Urbem\CoreBundle\Entity\SwCalculoInflator $fkSwCalculoInflator)
    {
        $this->formulaCalculo = $fkSwCalculoInflator->getCodCalculo();
        $this->fkSwCalculoInflator = $fkSwCalculoInflator;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCalculoInflator
     *
     * @return \Urbem\CoreBundle\Entity\SwCalculoInflator
     */
    public function getFkSwCalculoInflator()
    {
        return $this->fkSwCalculoInflator;
    }
}
