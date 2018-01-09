<?php
 
namespace Urbem\CoreBundle\Entity\Tcers;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\AjustePlanoContaModeloLrf
     */
    private $fkTcersAjustePlanoContaModeloLrfs;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcers\QuadroModeloLrf
     */
    private $fkTcersQuadroModeloLrf;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoConta
     */
    private $fkContabilidadePlanoConta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcersAjustePlanoContaModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcersAjustePlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\AjustePlanoContaModeloLrf $fkTcersAjustePlanoContaModeloLrf
     * @return PlanoContaModeloLrf
     */
    public function addFkTcersAjustePlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\AjustePlanoContaModeloLrf $fkTcersAjustePlanoContaModeloLrf)
    {
        if (false === $this->fkTcersAjustePlanoContaModeloLrfs->contains($fkTcersAjustePlanoContaModeloLrf)) {
            $fkTcersAjustePlanoContaModeloLrf->setFkTcersPlanoContaModeloLrf($this);
            $this->fkTcersAjustePlanoContaModeloLrfs->add($fkTcersAjustePlanoContaModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersAjustePlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\AjustePlanoContaModeloLrf $fkTcersAjustePlanoContaModeloLrf
     */
    public function removeFkTcersAjustePlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\AjustePlanoContaModeloLrf $fkTcersAjustePlanoContaModeloLrf)
    {
        $this->fkTcersAjustePlanoContaModeloLrfs->removeElement($fkTcersAjustePlanoContaModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersAjustePlanoContaModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\AjustePlanoContaModeloLrf
     */
    public function getFkTcersAjustePlanoContaModeloLrfs()
    {
        return $this->fkTcersAjustePlanoContaModeloLrfs;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcersQuadroModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\QuadroModeloLrf $fkTcersQuadroModeloLrf
     * @return PlanoContaModeloLrf
     */
    public function setFkTcersQuadroModeloLrf(\Urbem\CoreBundle\Entity\Tcers\QuadroModeloLrf $fkTcersQuadroModeloLrf)
    {
        $this->exercicio = $fkTcersQuadroModeloLrf->getExercicio();
        $this->codModelo = $fkTcersQuadroModeloLrf->getCodModelo();
        $this->codQuadro = $fkTcersQuadroModeloLrf->getCodQuadro();
        $this->fkTcersQuadroModeloLrf = $fkTcersQuadroModeloLrf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcersQuadroModeloLrf
     *
     * @return \Urbem\CoreBundle\Entity\Tcers\QuadroModeloLrf
     */
    public function getFkTcersQuadroModeloLrf()
    {
        return $this->fkTcersQuadroModeloLrf;
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
}
