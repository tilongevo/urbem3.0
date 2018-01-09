<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * AreaConhecimento
 */
class AreaConhecimento
{
    /**
     * PK
     * @var integer
     */
    private $codAreaConhecimento;

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
     * Set codAreaConhecimento
     *
     * @param integer $codAreaConhecimento
     * @return AreaConhecimento
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
     * Set descricao
     *
     * @param string $descricao
     * @return AreaConhecimento
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
     * @return AreaConhecimento
     */
    public function addFkEstagioCursos(\Urbem\CoreBundle\Entity\Estagio\Curso $fkEstagioCurso)
    {
        if (false === $this->fkEstagioCursos->contains($fkEstagioCurso)) {
            $fkEstagioCurso->setFkEstagioAreaConhecimento($this);
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
        return (string) $this->fkEstagioCursos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
