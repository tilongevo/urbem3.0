<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * ClassificacaoContabil
 */
class ClassificacaoContabil
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoContas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadePlanoContas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return ClassificacaoContabil
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
     * @return ClassificacaoContabil
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
     * @return ClassificacaoContabil
     */
    public function setNomClassificacao($nomClassificacao = null)
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
     * Add ContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return ClassificacaoContabil
     */
    public function addFkContabilidadePlanoContas(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta)
    {
        if (false === $this->fkContabilidadePlanoContas->contains($fkContabilidadePlanoConta)) {
            $fkContabilidadePlanoConta->setFkContabilidadeClassificacaoContabil($this);
            $this->fkContabilidadePlanoContas->add($fkContabilidadePlanoConta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     */
    public function removeFkContabilidadePlanoContas(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta)
    {
        $this->fkContabilidadePlanoContas->removeElement($fkContabilidadePlanoConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    public function getFkContabilidadePlanoContas()
    {
        return $this->fkContabilidadePlanoContas;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodClassificacao(), $this->nomClassificacao);
    }
}
