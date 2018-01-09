<?php
 
namespace Urbem\CoreBundle\Entity\Manad;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\AjusteRecursoModeloLrf
     */
    private $fkManadAjusteRecursoModeloLrfs;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;

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
        $this->fkManadAjusteRecursoModeloLrfs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add ManadAjusteRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\AjusteRecursoModeloLrf $fkManadAjusteRecursoModeloLrf
     * @return RecursoModeloLrf
     */
    public function addFkManadAjusteRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Manad\AjusteRecursoModeloLrf $fkManadAjusteRecursoModeloLrf)
    {
        if (false === $this->fkManadAjusteRecursoModeloLrfs->contains($fkManadAjusteRecursoModeloLrf)) {
            $fkManadAjusteRecursoModeloLrf->setFkManadRecursoModeloLrf($this);
            $this->fkManadAjusteRecursoModeloLrfs->add($fkManadAjusteRecursoModeloLrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ManadAjusteRecursoModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\AjusteRecursoModeloLrf $fkManadAjusteRecursoModeloLrf
     */
    public function removeFkManadAjusteRecursoModeloLrfs(\Urbem\CoreBundle\Entity\Manad\AjusteRecursoModeloLrf $fkManadAjusteRecursoModeloLrf)
    {
        $this->fkManadAjusteRecursoModeloLrfs->removeElement($fkManadAjusteRecursoModeloLrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkManadAjusteRecursoModeloLrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Manad\AjusteRecursoModeloLrf
     */
    public function getFkManadAjusteRecursoModeloLrfs()
    {
        return $this->fkManadAjusteRecursoModeloLrfs;
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

    /**
     * ManyToOne (inverse side)
     * Set fkManadQuadroModeloLrf
     *
     * @param \Urbem\CoreBundle\Entity\Manad\QuadroModeloLrf $fkManadQuadroModeloLrf
     * @return RecursoModeloLrf
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
