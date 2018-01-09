<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwClassificacaoContabil
 */
class SwClassificacaoContabil
{
    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomClassificacao;

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
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return SwClassificacaoContabil
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwClassificacaoContabil
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
     * Set nomClassificacao
     *
     * @param string $nomClassificacao
     * @return SwClassificacaoContabil
     */
    public function setNomClassificacao($nomClassificacao)
    {
        $this->nomClassificacao = $nomClassificacao;
        return $this;
    }

    /**
     * Get nomClassificacao
     *
     * @return string
     */
    public function getNomClassificacao()
    {
        return $this->nomClassificacao;
    }

    /**
     * OneToMany (owning side)
     * Add SwPlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\SwPlanoConta $fkSwPlanoConta
     * @return SwClassificacaoContabil
     */
    public function addFkSwPlanoContas(\Urbem\CoreBundle\Entity\SwPlanoConta $fkSwPlanoConta)
    {
        if (false === $this->fkSwPlanoContas->contains($fkSwPlanoConta)) {
            $fkSwPlanoConta->setFkSwClassificacaoContabil($this);
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
