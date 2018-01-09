<?php
 
namespace Urbem\CoreBundle\Entity\Tcers;

/**
 * RecursoModeloLrf
 */
class RecursoModeloLrf
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
     * PK
     * @var integer
     */
    private $codRecurso;

    /**
     * @var integer
     */
    private $ordem;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\AjusteRecursoModeloLrf
     */
    private $fkTcersAjusteRecursoModeloLrfs;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcers\QuadroModeloLrf
     */
    private $fkTcersQuadroModeloLrf;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcersAjusteRecursoModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return RecursoModeloLrf
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
     * @return RecursoModeloLrf
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
     * @return RecursoModeloLrf
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return RecursoModeloLrf
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set ordem
     *
     * @param integer $ordem
     * @return RecursoModeloLrf
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
     * Add TcersAjusteRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\AjusteRecursoModeloLrf $fkTcersAjusteRecursoModeloLrf
     * @return RecursoModeloLrf
     */
    public function addFkTcersAjusteRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\AjusteRecursoModeloLrf $fkTcersAjusteRecursoModeloLrf)
    {
        if (false === $this->fkTcersAjusteRecursoModeloLrfs->contains($fkTcersAjusteRecursoModeloLrf)) {
            $fkTcersAjusteRecursoModeloLrf->setFkTcersRecursoModeloLrf($this);
            $this->fkTcersAjusteRecursoModeloLrfs->add($fkTcersAjusteRecursoModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcersAjusteRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\AjusteRecursoModeloLrf $fkTcersAjusteRecursoModeloLrf
     */
    public function removeFkTcersAjusteRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Tcers\AjusteRecursoModeloLrf $fkTcersAjusteRecursoModeloLrf)
    {
        $this->fkTcersAjusteRecursoModeloLrfs->removeElement($fkTcersAjusteRecursoModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcersAjusteRecursoModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcers\AjusteRecursoModeloLrf
     */
    public function getFkTcersAjusteRecursoModeloLrfs()
    {
        return $this->fkTcersAjusteRecursoModeloLrfs;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcersQuadroModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\QuadroModeloLrf $fkTcersQuadroModeloLrf
     * @return RecursoModeloLrf
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
     * Set fkOrcamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso
     * @return RecursoModeloLrf
     */
    public function setFkOrcamentoRecurso(\Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso)
    {
        $this->exercicio = $fkOrcamentoRecurso->getExercicio();
        $this->codRecurso = $fkOrcamentoRecurso->getCodRecurso();
        $this->fkOrcamentoRecurso = $fkOrcamentoRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    public function getFkOrcamentoRecurso()
    {
        return $this->fkOrcamentoRecurso;
    }
}
