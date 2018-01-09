<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwTipoEmpenho
 */
class SwTipoEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    private $fkSwPreEmpenhos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return SwTipoEmpenho
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return SwTipoEmpenho
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * OneToMany (owning side)
     * Add SwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     * @return SwTipoEmpenho
     */
    public function addFkSwPreEmpenhos(\Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho)
    {
        if (false === $this->fkSwPreEmpenhos->contains($fkSwPreEmpenho)) {
            $fkSwPreEmpenho->setFkSwTipoEmpenho($this);
            $this->fkSwPreEmpenhos->add($fkSwPreEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho
     */
    public function removeFkSwPreEmpenhos(\Urbem\CoreBundle\Entity\SwPreEmpenho $fkSwPreEmpenho)
    {
        $this->fkSwPreEmpenhos->removeElement($fkSwPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPreEmpenho
     */
    public function getFkSwPreEmpenhos()
    {
        return $this->fkSwPreEmpenhos;
    }
}
