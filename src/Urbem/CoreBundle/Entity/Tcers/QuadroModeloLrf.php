<?php
 
namespace Urbem\CoreBundle\Entity\Tcers;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf
     */
    private $fkTcersPlanoContaModeloLrfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf
     */
    private $fkTcersRecursoModeloLrfs;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcers\ModeloLrf
     */
    private $fkTcersModeloLrf;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcersPlanoContaModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcersRecursoModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add TcersPlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf $fkTcersPlanoContaModeloLrf
     * @return QuadroModeloLrf
     */
    public function addFkTcersPlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf $fkTcersPlanoContaModeloLrf)
    {
        if (false === $this->fkTcersPlanoContaModeloLrfs->contains($fkTcersPlanoContaModeloLrf)) {
            $fkTcersPlanoContaModeloLrf->setFkTcersQuadroModeloLrf($this);
            $this->fkTcersPlanoContaModeloLrfs->add($fkTcersPlanoContaModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersPlanoContaModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf $fkTcersPlanoContaModeloLrf
     */
    public function removeFkTcersPlanoContaModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf $fkTcersPlanoContaModeloLrf)
    {
        $this->fkTcersPlanoContaModeloLrfs->removeElement($fkTcersPlanoContaModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersPlanoContaModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\PlanoContaModeloLrf
     */
    public function getFkTcersPlanoContaModeloLrfs()
    {
        return $this->fkTcersPlanoContaModeloLrfs;
    }

    /**
     * OneToMany (owning side)
     * Add TcersRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf $fkTcersRecursoModeloLrf
     * @return QuadroModeloLrf
     */
    public function addFkTcersRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf $fkTcersRecursoModeloLrf)
    {
        if (false === $this->fkTcersRecursoModeloLrfs->contains($fkTcersRecursoModeloLrf)) {
            $fkTcersRecursoModeloLrf->setFkTcersQuadroModeloLrf($this);
            $this->fkTcersRecursoModeloLrfs->add($fkTcersRecursoModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf $fkTcersRecursoModeloLrf
     */
    public function removeFkTcersRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf $fkTcersRecursoModeloLrf)
    {
        $this->fkTcersRecursoModeloLrfs->removeElement($fkTcersRecursoModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersRecursoModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\RecursoModeloLrf
     */
    public function getFkTcersRecursoModeloLrfs()
    {
        return $this->fkTcersRecursoModeloLrfs;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcersModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\ModeloLrf $fkTcersModeloLrf
     * @return QuadroModeloLrf
     */
    public function setFkTcersModeloLrf(\Urbem\CoreBundle\Entity\Tcers\ModeloLrf $fkTcersModeloLrf)
    {
        $this->exercicio = $fkTcersModeloLrf->getExercicio();
        $this->codModelo = $fkTcersModeloLrf->getCodModelo();
        $this->fkTcersModeloLrf = $fkTcersModeloLrf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcersModeloLrf
     *
     * @return \Urbem\CoreBundle\Entity\Tcers\ModeloLrf
     */
    public function getFkTcersModeloLrf()
    {
        return $this->fkTcersModeloLrf;
    }
}
