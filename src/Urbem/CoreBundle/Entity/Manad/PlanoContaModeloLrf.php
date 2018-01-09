<?php
 
namespace Urbem\CoreBundle\Entity\Manad;

/**
 * PlanoContaModeloLrf
 */
class PlanoContaModeloLrf
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codModelo;

    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * PK
     * @var integer
     */
    private $codQuadro;

    /**
     * @var boolean
     */
    private $redutora;

    /**
     * @var integer
     */
    private $ordem;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\AjustePlanoContaModeloLrf
     */
    private $fkManadAjustePlanoContaModeloLrfs;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoConta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Manad\QuadroModeloLrf
     */
    private $fkManadQuadroModeloLrf;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkManadAjustePlanoContaModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PlanoContaModeloLrf
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
     * Set codModelo
     *
     * @param integer $codModelo
     * @return PlanoContaModeloLrf
     */
    public function setCodModelo($codModelo)
    {
        $this->codModelo = $codModelo;
        return $this;
    }

    /**
     * Get codModelo
     *
     * @return integer
     */
    public function getCodModelo()
    {
        return $this->codModelo;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return PlanoContaModeloLrf
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set codQuadro
     *
     * @param integer $codQuadro
     * @return PlanoContaModeloLrf
     */
    public function setCodQuadro($codQuadro)
    {
        $this->codQuadro = $codQuadro;
        return $this;
    }

    /**
     * Get codQuadro
     *
     * @return integer
     */
    public function getCodQuadro()
    {
        return $this->codQuadro;
    }

    /**
     * Set redutora
     *
     * @param boolean $redutora
     * @return PlanoContaModeloLrf
     */
    public function setRedutora($redutora)
    {
        $this->redutora = $redutora;
        return $this;
    }

    /**
     * Get redutora
     *
     * @return boolean
     */
    public function getRedutora()
    {
        return $this->redutora;
    }

    /**
     * Set ordem
     *
     * @param integer $ordem
     * @return PlanoContaModeloLrf
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * Get ordem
     *
     * @return integer
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * OneToMany (owning side)
     * Add ManadAjustePlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\AjustePlanoContaModeloLrf $fkManadAjustePlanoContaModeloLrf
     * @return PlanoContaModeloLrf
     */
    public function addFkManadAjustePlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Manad\AjustePlanoContaModeloLrf $fkManadAjustePlanoContaModeloLrf)
    {
        if (false === $this->fkManadAjustePlanoContaModeloLrfs->contains($fkManadAjustePlanoContaModeloLrf)) {
            $fkManadAjustePlanoContaModeloLrf->setFkManadPlanoContaModeloLrf($this);
            $this->fkManadAjustePlanoContaModeloLrfs->add($fkManadAjustePlanoContaModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadAjustePlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\AjustePlanoContaModeloLrf $fkManadAjustePlanoContaModeloLrf
     */
    public function removeFkManadAjustePlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Manad\AjustePlanoContaModeloLrf $fkManadAjustePlanoContaModeloLrf)
    {
        $this->fkManadAjustePlanoContaModeloLrfs->removeElement($fkManadAjustePlanoContaModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadAjustePlanoContaModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\AjustePlanoContaModeloLrf
     */
    public function getFkManadAjustePlanoContaModeloLrfs()
    {
        return $this->fkManadAjustePlanoContaModeloLrfs;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoConta
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta
     * @return PlanoContaModeloLrf
     */
    public function setFkContabilidadePlanoConta(\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta $fkContabilidadePlanoConta)
    {
        $this->codConta = $fkContabilidadePlanoConta->getCodConta();
        $this->exercicio = $fkContabilidadePlanoConta->getExercicio();
        $this->fkContabilidadePlanoConta = $fkContabilidadePlanoConta;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoConta
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    public function getFkContabilidadePlanoConta()
    {
        return $this->fkContabilidadePlanoConta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkManadQuadroModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\QuadroModeloLrf $fkManadQuadroModeloLrf
     * @return PlanoContaModeloLrf
     */
    public function setFkManadQuadroModeloLrf(\Urbem\CoreBundle\Entity\Manad\QuadroModeloLrf $fkManadQuadroModeloLrf)
    {
        $this->exercicio = $fkManadQuadroModeloLrf->getExercicio();
        $this->codModelo = $fkManadQuadroModeloLrf->getCodModelo();
        $this->codQuadro = $fkManadQuadroModeloLrf->getCodQuadro();
        $this->fkManadQuadroModeloLrf = $fkManadQuadroModeloLrf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkManadQuadroModeloLrf
     *
     * @return \Urbem\CoreBundle\Entity\Manad\QuadroModeloLrf
     */
    public function getFkManadQuadroModeloLrf()
    {
        return $this->fkManadQuadroModeloLrf;
    }
}
