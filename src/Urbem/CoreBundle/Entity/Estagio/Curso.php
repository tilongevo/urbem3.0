<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * Curso
 */
class Curso
{
    /**
     * PK
     * @var integer
     */
    private $codCurso;

    /**
     * @var integer
     */
    private $codGrau;

    /**
     * @var integer
     */
    private $codAreaConhecimento;

    /**
     * @var string
     */
    private $nomCurso;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino
     */
    private $fkEstagioCursoInstituicaoEnsinos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\Grau
     */
    private $fkEstagioGrau;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Estagio\AreaConhecimento
     */
    private $fkEstagioAreaConhecimento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEstagioCursoInstituicaoEnsinos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCurso
     *
     * @param integer $codCurso
     * @return Curso
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
     * Set codGrau
     *
     * @param integer $codGrau
     * @return Curso
     */
    public function setCodGrau($codGrau)
    {
        $this->codGrau = $codGrau;
        return $this;
    }

    /**
     * Get codGrau
     *
     * @return integer
     */
    public function getCodGrau()
    {
        return $this->codGrau;
    }

    /**
     * Set codAreaConhecimento
     *
     * @param integer $codAreaConhecimento
     * @return Curso
     */
    public function setCodAreaConhecimento($codAreaConhecimento)
    {
        $this->codAreaConhecimento = $codAreaConhecimento;
        return $this;
    }

    /**
     * Get codAreaConhecimento
     *
     * @return integer
     */
    public function getCodAreaConhecimento()
    {
        return $this->codAreaConhecimento;
    }

    /**
     * Set nomCurso
     *
     * @param string $nomCurso
     * @return Curso
     */
    public function setNomCurso($nomCurso)
    {
        $this->nomCurso = $nomCurso;
        return $this;
    }

    /**
     * Get nomCurso
     *
     * @return string
     */
    public function getNomCurso()
    {
        return $this->nomCurso;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioCursoInstituicaoEnsino
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino $fkEstagioCursoInstituicaoEnsino
     * @return Curso
     */
    public function addFkEstagioCursoInstituicaoEnsinos(\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino $fkEstagioCursoInstituicaoEnsino)
    {
        if (false === $this->fkEstagioCursoInstituicaoEnsinos->contains($fkEstagioCursoInstituicaoEnsino)) {
            $fkEstagioCursoInstituicaoEnsino->setFkEstagioCurso($this);
            $this->fkEstagioCursoInstituicaoEnsinos->add($fkEstagioCursoInstituicaoEnsino);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioCursoInstituicaoEnsino
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino $fkEstagioCursoInstituicaoEnsino
     */
    public function removeFkEstagioCursoInstituicaoEnsinos(\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino $fkEstagioCursoInstituicaoEnsino)
    {
        $this->fkEstagioCursoInstituicaoEnsinos->removeElement($fkEstagioCursoInstituicaoEnsino);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioCursoInstituicaoEnsinos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino
     */
    public function getFkEstagioCursoInstituicaoEnsinos()
    {
        return $this->fkEstagioCursoInstituicaoEnsinos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioGrau
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\Grau $fkEstagioGrau
     * @return Curso
     */
    public function setFkEstagioGrau(\Urbem\CoreBundle\Entity\Estagio\Grau $fkEstagioGrau)
    {
        $this->codGrau = $fkEstagioGrau->getCodGrau();
        $this->fkEstagioGrau = $fkEstagioGrau;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioGrau
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\Grau
     */
    public function getFkEstagioGrau()
    {
        return $this->fkEstagioGrau;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEstagioAreaConhecimento
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\AreaConhecimento $fkEstagioAreaConhecimento
     * @return Curso
     */
    public function setFkEstagioAreaConhecimento(\Urbem\CoreBundle\Entity\Estagio\AreaConhecimento $fkEstagioAreaConhecimento)
    {
        $this->codAreaConhecimento = $fkEstagioAreaConhecimento->getCodAreaConhecimento();
        $this->fkEstagioAreaConhecimento = $fkEstagioAreaConhecimento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEstagioAreaConhecimento
     *
     * @return \Urbem\CoreBundle\Entity\Estagio\AreaConhecimento
     */
    public function getFkEstagioAreaConhecimento()
    {
        return $this->fkEstagioAreaConhecimento;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomCurso;
    }
}
