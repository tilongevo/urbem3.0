<?php
 
namespace Urbem\CoreBundle\Entity\Estagio;

/**
 * EntidadeIntermediadora
 */
class EntidadeIntermediadora
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $percentualAtual;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EntidadeContribuicao
     */
    private $fkEstagioEntidadeContribuicoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\InstituicaoEntidade
     */
    private $fkEstagioInstituicaoEntidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio
     */
    private $fkEstagioEntidadeIntermediadoraEstagios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEstagioEntidadeContribuicoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioInstituicaoEntidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioEntidadeIntermediadoraEstagios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return EntidadeIntermediadora
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
     * Set percentualAtual
     *
     * @param integer $percentualAtual
     * @return EntidadeIntermediadora
     */
    public function setPercentualAtual($percentualAtual)
    {
        $this->percentualAtual = $percentualAtual;
        return $this;
    }

    /**
     * Get percentualAtual
     *
     * @return integer
     */
    public function getPercentualAtual()
    {
        return $this->percentualAtual;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioEntidadeContribuicao
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EntidadeContribuicao $fkEstagioEntidadeContribuicao
     * @return EntidadeIntermediadora
     */
    public function addFkEstagioEntidadeContribuicoes(\Urbem\CoreBundle\Entity\Estagio\EntidadeContribuicao $fkEstagioEntidadeContribuicao)
    {
        if (false === $this->fkEstagioEntidadeContribuicoes->contains($fkEstagioEntidadeContribuicao)) {
            $fkEstagioEntidadeContribuicao->setFkEstagioEntidadeIntermediadora($this);
            $this->fkEstagioEntidadeContribuicoes->add($fkEstagioEntidadeContribuicao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEntidadeContribuicao
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EntidadeContribuicao $fkEstagioEntidadeContribuicao
     */
    public function removeFkEstagioEntidadeContribuicoes(\Urbem\CoreBundle\Entity\Estagio\EntidadeContribuicao $fkEstagioEntidadeContribuicao)
    {
        $this->fkEstagioEntidadeContribuicoes->removeElement($fkEstagioEntidadeContribuicao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEntidadeContribuicoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EntidadeContribuicao
     */
    public function getFkEstagioEntidadeContribuicoes()
    {
        return $this->fkEstagioEntidadeContribuicoes;
    }

    /**
     * OneToMany (owning side)
     * Add EstagioInstituicaoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\InstituicaoEntidade $fkEstagioInstituicaoEntidade
     * @return EntidadeIntermediadora
     */
    public function addFkEstagioInstituicaoEntidades(\Urbem\CoreBundle\Entity\Estagio\InstituicaoEntidade $fkEstagioInstituicaoEntidade)
    {
        if (false === $this->fkEstagioInstituicaoEntidades->contains($fkEstagioInstituicaoEntidade)) {
            $fkEstagioInstituicaoEntidade->setFkEstagioEntidadeIntermediadora($this);
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
     * OneToMany (owning side)
     * Add EstagioEntidadeIntermediadoraEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio $fkEstagioEntidadeIntermediadoraEstagio
     * @return EntidadeIntermediadora
     */
    public function addFkEstagioEntidadeIntermediadoraEstagios(\Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio $fkEstagioEntidadeIntermediadoraEstagio)
    {
        if (false === $this->fkEstagioEntidadeIntermediadoraEstagios->contains($fkEstagioEntidadeIntermediadoraEstagio)) {
            $fkEstagioEntidadeIntermediadoraEstagio->setFkEstagioEntidadeIntermediadora($this);
            $this->fkEstagioEntidadeIntermediadoraEstagios->add($fkEstagioEntidadeIntermediadoraEstagio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEntidadeIntermediadoraEstagio
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio $fkEstagioEntidadeIntermediadoraEstagio
     */
    public function removeFkEstagioEntidadeIntermediadoraEstagios(\Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio $fkEstagioEntidadeIntermediadoraEstagio)
    {
        $this->fkEstagioEntidadeIntermediadoraEstagios->removeElement($fkEstagioEntidadeIntermediadoraEstagio);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEntidadeIntermediadoraEstagios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadoraEstagio
     */
    public function getFkEstagioEntidadeIntermediadoraEstagios()
    {
        return $this->fkEstagioEntidadeIntermediadoraEstagios;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return EntidadeIntermediadora
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
