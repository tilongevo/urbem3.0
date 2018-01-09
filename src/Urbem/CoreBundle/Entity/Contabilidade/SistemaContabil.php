<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * SistemaContabil
 */
class SistemaContabil
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
     * @var string
     */
    private $grupos;

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
     * Set codSistema
     *
     * @param integer $codSistema
     * @return SistemaContabil
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
     * @return SistemaContabil
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
     * @return SistemaContabil
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
     * Set grupos
     *
     * @param string $grupos
     * @return SistemaContabil
     */
    public function setGrupos($grupos = null)
    {
        $this->grupos = $grupos;
        return $this;
    }

    /**
     * Get grupos
     *
     * @return string
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return SistemaContabil
     */
    public function addFkContabilidadePlanoContas(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta)
    {
        if (false === $this->fkContabilidadePlanoContas->contains($fkContabilidadePlanoConta)) {
            $fkContabilidadePlanoConta->setFkContabilidadeSistemaContabil($this);
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
        return sprintf('%s - %s', $this->getCodSistema(), $this->getNomSistema());
    }
}
