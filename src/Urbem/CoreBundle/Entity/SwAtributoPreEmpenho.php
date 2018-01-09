<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAtributoPreEmpenho
 */
class SwAtributoPreEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomAtributo;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $valorPadrao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwValorAtributoPreEmpenho
     */
    private $fkSwValorAtributoPreEmpenhos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwValorAtributoPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return SwAtributoPreEmpenho
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwAtributoPreEmpenho
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
     * Set nomAtributo
     *
     * @param string $nomAtributo
     * @return SwAtributoPreEmpenho
     */
    public function setNomAtributo($nomAtributo)
    {
        $this->nomAtributo = $nomAtributo;
        return $this;
    }

    /**
     * Get nomAtributo
     *
     * @return string
     */
    public function getNomAtributo()
    {
        return $this->nomAtributo;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return SwAtributoPreEmpenho
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set valorPadrao
     *
     * @param string $valorPadrao
     * @return SwAtributoPreEmpenho
     */
    public function setValorPadrao($valorPadrao)
    {
        $this->valorPadrao = $valorPadrao;
        return $this;
    }

    /**
     * Get valorPadrao
     *
     * @return string
     */
    public function getValorPadrao()
    {
        return $this->valorPadrao;
    }

    /**
     * OneToMany (owning side)
     * Add SwValorAtributoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwValorAtributoPreEmpenho $fkSwValorAtributoPreEmpenho
     * @return SwAtributoPreEmpenho
     */
    public function addFkSwValorAtributoPreEmpenhos(\Urbem\CoreBundle\Entity\SwValorAtributoPreEmpenho $fkSwValorAtributoPreEmpenho)
    {
        if (false === $this->fkSwValorAtributoPreEmpenhos->contains($fkSwValorAtributoPreEmpenho)) {
            $fkSwValorAtributoPreEmpenho->setFkSwAtributoPreEmpenho($this);
            $this->fkSwValorAtributoPreEmpenhos->add($fkSwValorAtributoPreEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwValorAtributoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwValorAtributoPreEmpenho $fkSwValorAtributoPreEmpenho
     */
    public function removeFkSwValorAtributoPreEmpenhos(\Urbem\CoreBundle\Entity\SwValorAtributoPreEmpenho $fkSwValorAtributoPreEmpenho)
    {
        $this->fkSwValorAtributoPreEmpenhos->removeElement($fkSwValorAtributoPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwValorAtributoPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwValorAtributoPreEmpenho
     */
    public function getFkSwValorAtributoPreEmpenhos()
    {
        return $this->fkSwValorAtributoPreEmpenhos;
    }
}
