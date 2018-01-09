<?php
 
namespace Urbem\CoreBundle\Entity\Manad;

/**
 * QuadroModeloLrf
 */
class QuadroModeloLrf
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
    private $codQuadro;

    /**
     * @var string
     */
    private $nomQuadro;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf
     */
    private $fkManadRecursoModeloLrfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\PlanoContaModeloLrf
     */
    private $fkManadPlanoContaModeloLrfs;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Manad\ModeloLrf
     */
    private $fkManadModeloLrf;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkManadRecursoModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkManadPlanoContaModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return QuadroModeloLrf
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
     * @return QuadroModeloLrf
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
     * Set codQuadro
     *
     * @param integer $codQuadro
     * @return QuadroModeloLrf
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
     * Set nomQuadro
     *
     * @param string $nomQuadro
     * @return QuadroModeloLrf
     */
    public function setNomQuadro($nomQuadro)
    {
        $this->nomQuadro = $nomQuadro;
        return $this;
    }

    /**
     * Get nomQuadro
     *
     * @return string
     */
    public function getNomQuadro()
    {
        return $this->nomQuadro;
    }

    /**
     * OneToMany (owning side)
     * Add ManadRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf $fkManadRecursoModeloLrf
     * @return QuadroModeloLrf
     */
    public function addFkManadRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf $fkManadRecursoModeloLrf)
    {
        if (false === $this->fkManadRecursoModeloLrfs->contains($fkManadRecursoModeloLrf)) {
            $fkManadRecursoModeloLrf->setFkManadQuadroModeloLrf($this);
            $this->fkManadRecursoModeloLrfs->add($fkManadRecursoModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf $fkManadRecursoModeloLrf
     */
    public function removeFkManadRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf $fkManadRecursoModeloLrf)
    {
        $this->fkManadRecursoModeloLrfs->removeElement($fkManadRecursoModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadRecursoModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\RecursoModeloLrf
     */
    public function getFkManadRecursoModeloLrfs()
    {
        return $this->fkManadRecursoModeloLrfs;
    }

    /**
     * OneToMany (owning side)
     * Add ManadPlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\PlanoContaModeloLrf $fkManadPlanoContaModeloLrf
     * @return QuadroModeloLrf
     */
    public function addFkManadPlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Manad\PlanoContaModeloLrf $fkManadPlanoContaModeloLrf)
    {
        if (false === $this->fkManadPlanoContaModeloLrfs->contains($fkManadPlanoContaModeloLrf)) {
            $fkManadPlanoContaModeloLrf->setFkManadQuadroModeloLrf($this);
            $this->fkManadPlanoContaModeloLrfs->add($fkManadPlanoContaModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadPlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\PlanoContaModeloLrf $fkManadPlanoContaModeloLrf
     */
    public function removeFkManadPlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Manad\PlanoContaModeloLrf $fkManadPlanoContaModeloLrf)
    {
        $this->fkManadPlanoContaModeloLrfs->removeElement($fkManadPlanoContaModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadPlanoContaModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\PlanoContaModeloLrf
     */
    public function getFkManadPlanoContaModeloLrfs()
    {
        return $this->fkManadPlanoContaModeloLrfs;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkManadModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\ModeloLrf $fkManadModeloLrf
     * @return QuadroModeloLrf
     */
    public function setFkManadModeloLrf(\Urbem\CoreBundle\Entity\Manad\ModeloLrf $fkManadModeloLrf)
    {
        $this->exercicio = $fkManadModeloLrf->getExercicio();
        $this->codModelo = $fkManadModeloLrf->getCodModelo();
        $this->fkManadModeloLrf = $fkManadModeloLrf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkManadModeloLrf
     *
     * @return \Urbem\CoreBundle\Entity\Manad\ModeloLrf
     */
    public function getFkManadModeloLrf()
    {
        return $this->fkManadModeloLrf;
    }
}
