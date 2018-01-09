<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * Grau
 */
class Grau
{
    /**
     * PK
     * @var integer
     */
    private $codGrau;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\Curso
     */
    private $fkEstagioCursos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEstagioCursos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrau
     *
     * @param integer $codGrau
     * @return Grau
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
     * Set descricao
     *
     * @param string $descricao
     * @return Grau
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioCurso
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\Curso $fkEstagioCurso
     * @return Grau
     */
    public function addFkEstagioCursos(\Urbem\CoreBundle\Entity\Estagio\Curso $fkEstagioCurso)
    {
        if (false === $this->fkEstagioCursos->contains($fkEstagioCurso)) {
            $fkEstagioCurso->setFkEstagioGrau($this);
            $this->fkEstagioCursos->add($fkEstagioCurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioCurso
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\Curso $fkEstagioCurso
     */
    public function removeFkEstagioCursos(\Urbem\CoreBundle\Entity\Estagio\Curso $fkEstagioCurso)
    {
        $this->fkEstagioCursos->removeElement($fkEstagioCurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioCursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\Curso
     */
    public function getFkEstagioCursos()
    {
        return $this->fkEstagioCursos;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
