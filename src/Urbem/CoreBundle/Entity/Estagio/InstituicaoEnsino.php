<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * InstituicaoEnsino
 */
class InstituicaoEnsino
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino
     */
    private $fkEstagioCursoInstituicaoEnsinos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\InstituicaoEntidade
     */
    private $fkEstagioInstituicaoEntidades;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEstagioCursoInstituicaoEnsinos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioInstituicaoEntidades = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return InstituicaoEnsino
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
     * OneToMany (owning side)
     * Add EstagioCursoInstituicaoEnsino
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino $fkEstagioCursoInstituicaoEnsino
     * @return InstituicaoEnsino
     */
    public function addFkEstagioCursoInstituicaoEnsinos(\Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino $fkEstagioCursoInstituicaoEnsino)
    {
        if (false === $this->fkEstagioCursoInstituicaoEnsinos->contains($fkEstagioCursoInstituicaoEnsino)) {
            $fkEstagioCursoInstituicaoEnsino->setFkEstagioInstituicaoEnsino($this);
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
     * OneToMany (owning side)
     * Add EstagioInstituicaoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\InstituicaoEntidade $fkEstagioInstituicaoEntidade
     * @return InstituicaoEnsino
     */
    public function addFkEstagioInstituicaoEntidades(\Urbem\CoreBundle\Entity\Estagio\InstituicaoEntidade $fkEstagioInstituicaoEntidade)
    {
        if (false === $this->fkEstagioInstituicaoEntidades->contains($fkEstagioInstituicaoEntidade)) {
            $fkEstagioInstituicaoEntidade->setFkEstagioInstituicaoEnsino($this);
            $this->fkEstagioInstituicaoEntidades->add($fkEstagioInstituicaoEntidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioInstituicaoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\InstituicaoEntidade $fkEstagioInstituicaoEntidade
     */
    public function removeFkEstagioInstituicaoEntidades(\Urbem\CoreBundle\Entity\Estagio\InstituicaoEntidade $fkEstagioInstituicaoEntidade)
    {
        $this->fkEstagioInstituicaoEntidades->removeElement($fkEstagioInstituicaoEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioInstituicaoEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\InstituicaoEntidade
     */
    public function getFkEstagioInstituicaoEntidades()
    {
        return $this->fkEstagioInstituicaoEntidades;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return InstituicaoEnsino
     */
    public function setFkSwCgmPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $this->numcgm = $fkSwCgmPessoaJuridica->getNumcgm();
        $this->fkSwCgmPessoaJuridica = $fkSwCgmPessoaJuridica;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgmPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridica()
    {
        return $this->fkSwCgmPessoaJuridica;
    }

    public function __toString()
    {
        return (string) $this->getFkSwCgmPessoaJuridica();
    }
}