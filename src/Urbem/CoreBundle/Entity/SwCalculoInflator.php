<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwCalculoInflator
 */
class SwCalculoInflator
{
    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwInflator
     */
    private $fkSwInflatores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwInflatores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCalculo
     *
     * @param integer $codCalculo
     * @return SwCalculoInflator
     */
    public function setCodCalculo($codCalculo)
    {
        $this->codCalculo = $codCalculo;
        return $this;
    }

    /**
     * Get codCalculo
     *
     * @return integer
     */
    public function getCodCalculo()
    {
        return $this->codCalculo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return SwCalculoInflator
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
     * OneToMany (owning side)
     * Add SwInflator
     *
     * @param \Urbem\CoreBundle\Entity\SwInflator $fkSwInflator
     * @return SwCalculoInflator
     */
    public function addFkSwInflatores(\Urbem\CoreBundle\Entity\SwInflator $fkSwInflator)
    {
        if (false === $this->fkSwInflatores->contains($fkSwInflator)) {
            $fkSwInflator->setFkSwCalculoInflator($this);
            $this->fkSwInflatores->add($fkSwInflator);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwInflator
     *
     * @param \Urbem\CoreBundle\Entity\SwInflator $fkSwInflator
     */
    public function removeFkSwInflatores(\Urbem\CoreBundle\Entity\SwInflator $fkSwInflator)
    {
        $this->fkSwInflatores->removeElement($fkSwInflator);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwInflatores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwInflator
     */
    public function getFkSwInflatores()
    {
        return $this->fkSwInflatores;
    }
}
