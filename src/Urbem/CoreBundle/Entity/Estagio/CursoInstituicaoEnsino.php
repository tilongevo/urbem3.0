<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * CursoInstituicaoEnsino
 */
class CursoInstituicaoEnsino
{
    /**
     * PK
     * @var integer
     */
    private $codCurso;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $vlBolsa;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsinoMes
     */
    private $fkEstagioCursoInstituicaoEnsinoMes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    private $fkEstagioEstagiarioEstagios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\Curso
     */
    private $fkEstagioCurso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino
     */
    private $fkEstagioInstituicaoEnsino;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEstagioEstagiarioEstagios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCurso
     *
     * @param integer $codCurso
     * @return CursoInstituicaoEnsino
     */
    public function setCodCurso($codCurso)
    {
        $this->codCurso = $codCurso;
        return $this;
    }

    /**
     * Get codCurso
     *
     * @return integer
     */
    public function getCodCurso()
    {
        return $this->codCurso;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return CursoInstituicaoEnsino
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set vlBolsa
     *
     * @param integer $vlBolsa
     * @return CursoInstituicaoEnsino
     */
    public function setVlBolsa($vlBolsa = null)
    {
        $this->vlBolsa = $vlBolsa;
        return $this;
    }

    /**
     * Get vlBolsa
     *
     * @return integer
     */
    public function getVlBolsa()
    {
        return $this->vlBolsa;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio
     * @return CursoInstituicaoEnsino
     */
    public function addFkEstagioEstagiarioEstagios(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio)
    {
        if (false === $this->fkEstagioEstagiarioEstagios->contains($fkEstagioEstagiarioEstagio)) {
            $fkEstagioEstagiarioEstagio->setFkEstagioCursoInstituicaoEnsino($this);
            $this->fkEstagioEstagiarioEstagios->add($fkEstagioEstagiarioEstagio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEstagiarioEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio
     */
    public function removeFkEstagioEstagiarioEstagios(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio $fkEstagioEstagiarioEstagio)
    {
        $this->fkEstagioEstagiarioEstagios->removeElement($fkEstagioEstagiarioEstagio);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEstagiarioEstagios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio
     */
    public function getFkEstagioEstagiarioEstagios()
    {
        return $this->fkEstagioEstagiarioEstagios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioCurso
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\Curso $fkEstagioCurso
     * @return CursoInstituicaoEnsino
     */
    public function setFkEstagioCurso(\Urbem\CoreBundle\Entity\Estagio\Curso $fkEstagioCurso)
    {
        $this->codCurso = $fkEstagioCurso->getCodCurso();
        $this->fkEstagioCurso = $fkEstagioCurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioCurso
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\Curso
     */
    public function getFkEstagioCurso()
    {
        return $this->fkEstagioCurso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioInstituicaoEnsino
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino $fkEstagioInstituicaoEnsino
     * @return CursoInstituicaoEnsino
     */
    public function setFkEstagioInstituicaoEnsino(\Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino $fkEstagioInstituicaoEnsino)
    {
        $this->numcgm = $fkEstagioInstituicaoEnsino->getNumcgm();
        $this->fkEstagioInstituicaoEnsino = $fkEstagioInstituicaoEnsino;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioInstituicaoEnsino
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino
     */
    public function getFkEstagioInstituicaoEnsino()
    {
        return $this->fkEstagioInstituicaoEnsino;
    }

    /**
     * OneToOne (inverse side)
     * Set EstagioCursoInstituicaoEnsinoMes
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsinoMes $fkEstagioCursoInstituicaoEnsinoMes
     * @return CursoInstituicaoEnsino
     */
    public function setFkEstagioCursoInstituicaoEnsinoMes(\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsinoMes $fkEstagioCursoInstituicaoEnsinoMes)
    {
        $fkEstagioCursoInstituicaoEnsinoMes->setFkEstagioCursoInstituicaoEnsino($this);
        $this->fkEstagioCursoInstituicaoEnsinoMes = $fkEstagioCursoInstituicaoEnsinoMes;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEstagioCursoInstituicaoEnsinoMes
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsinoMes
     */
    public function getFkEstagioCursoInstituicaoEnsinoMes()
    {
        return $this->fkEstagioCursoInstituicaoEnsinoMes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->codCurso) {
            return sprintf('%s - %s', $this->fkEstagioInstituicaoEnsino, $this->fkEstagioCurso);
        } else {
            return (string) "Curso Instituição de Ensino";
        }
    }
}
