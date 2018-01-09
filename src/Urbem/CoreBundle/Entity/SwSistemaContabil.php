<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwSistemaContabil
 */
class SwSistemaContabil
{
    /**
     * PK
     * @var integer
     */
    private $codSistema;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomSistema;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPlanoConta
     */
    private $fkSwPlanoContas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwPlanoContas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSistema
     *
     * @param integer $codSistema
     * @return SwSistemaContabil
     */
    public function setCodSistema($codSistema)
    {
        $this->codSistema = $codSistema;
        return $this;
    }

    /**
     * Get codSistema
     *
     * @return integer
     */
    public function getCodSistema()
    {
        return $this->codSistema;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwSistemaContabil
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
     * Set nomSistema
     *
     * @param string $nomSistema
     * @return SwSistemaContabil
     */
    public function setNomSistema($nomSistema)
    {
        $this->nomSistema = $nomSistema;
        return $this;
    }

    /**
     * Get nomSistema
     *
     * @return string
     */
    public function getNomSistema()
    {
        return $this->nomSistema;
    }

    /**
     * OneToMany (owning side)
     * Add SwPlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\SwPlanoConta $fkSwPlanoConta
     * @return SwSistemaContabil
     */
    public function addFkSwPlanoContas(\Urbem\CoreBundle\Entity\SwPlanoConta $fkSwPlanoConta)
    {
        if (false === $this->fkSwPlanoContas->contains($fkSwPlanoConta)) {
            $fkSwPlanoConta->setFkSwSistemaContabil($this);
            $this->fkSwPlanoContas->add($fkSwPlanoConta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwPlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\SwPlanoConta $fkSwPlanoConta
     */
    public function removeFkSwPlanoContas(\Urbem\CoreBundle\Entity\SwPlanoConta $fkSwPlanoConta)
    {
        $this->fkSwPlanoContas->removeElement($fkSwPlanoConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwPlanoContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPlanoConta
     */
    public function getFkSwPlanoContas()
    {
        return $this->fkSwPlanoContas;
    }
}
