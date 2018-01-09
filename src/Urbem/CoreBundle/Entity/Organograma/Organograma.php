<?php
 
namespace Urbem\CoreBundle\Entity\Organograma;

/**
 * Organograma
 */
class Organograma
{
    /**
     * PK
     * @var integer
     */
    private $codOrganograma;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var \DateTime
     */
    private $implantacao;

    /**
     * @var boolean
     */
    private $ativo = false;

    /**
     * @var boolean
     */
    private $permissaoHierarquica = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\OrganogramaNivel
     */
    private $fkOrcamentoOrganogramaNiveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico
     */
    private $fkOrganogramaDeParaOrgaoHistoricos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\Nivel
     */
    private $fkOrganogramaNiveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaOrgao
     */
    private $fkOrganogramaDeParaOrgoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoOrganogramaNiveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaDeParaOrgaoHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaNiveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaDeParaOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codOrganograma
     *
     * @param integer $codOrganograma
     * @return Organograma
     */
    public function setCodOrganograma($codOrganograma)
    {
        $this->codOrganograma = $codOrganograma;
        return $this;
    }

    /**
     * Get codOrganograma
     *
     * @return integer
     */
    public function getCodOrganograma()
    {
        return $this->codOrganograma;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return Organograma
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set implantacao
     *
     * @param \DateTime $implantacao
     * @return Organograma
     */
    public function setImplantacao(\DateTime $implantacao)
    {
        $this->implantacao = $implantacao;
        return $this;
    }

    /**
     * Get implantacao
     *
     * @return \DateTime
     */
    public function getImplantacao()
    {
        return $this->implantacao;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Organograma
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set permissaoHierarquica
     *
     * @param boolean $permissaoHierarquica
     * @return Organograma
     */
    public function setPermissaoHierarquica($permissaoHierarquica)
    {
        $this->permissaoHierarquica = $permissaoHierarquica;
        return $this;
    }

    /**
     * Get permissaoHierarquica
     *
     * @return boolean
     */
    public function getPermissaoHierarquica()
    {
        return $this->permissaoHierarquica;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoOrganogramaNivel
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\OrganogramaNivel $fkOrcamentoOrganogramaNivel
     * @return Organograma
     */
    public function addFkOrcamentoOrganogramaNiveis(\Urbem\CoreBundle\Entity\Orcamento\OrganogramaNivel $fkOrcamentoOrganogramaNivel)
    {
        if (false === $this->fkOrcamentoOrganogramaNiveis->contains($fkOrcamentoOrganogramaNivel)) {
            $fkOrcamentoOrganogramaNivel->setFkOrganogramaOrganograma($this);
            $this->fkOrcamentoOrganogramaNiveis->add($fkOrcamentoOrganogramaNivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoOrganogramaNivel
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\OrganogramaNivel $fkOrcamentoOrganogramaNivel
     */
    public function removeFkOrcamentoOrganogramaNiveis(\Urbem\CoreBundle\Entity\Orcamento\OrganogramaNivel $fkOrcamentoOrganogramaNivel)
    {
        $this->fkOrcamentoOrganogramaNiveis->removeElement($fkOrcamentoOrganogramaNivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoOrganogramaNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\OrganogramaNivel
     */
    public function getFkOrcamentoOrganogramaNiveis()
    {
        return $this->fkOrcamentoOrganogramaNiveis;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaDeParaOrgaoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico $fkOrganogramaDeParaOrgaoHistorico
     * @return Organograma
     */
    public function addFkOrganogramaDeParaOrgaoHistoricos(\Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico $fkOrganogramaDeParaOrgaoHistorico)
    {
        if (false === $this->fkOrganogramaDeParaOrgaoHistoricos->contains($fkOrganogramaDeParaOrgaoHistorico)) {
            $fkOrganogramaDeParaOrgaoHistorico->setFkOrganogramaOrganograma($this);
            $this->fkOrganogramaDeParaOrgaoHistoricos->add($fkOrganogramaDeParaOrgaoHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaDeParaOrgaoHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico $fkOrganogramaDeParaOrgaoHistorico
     */
    public function removeFkOrganogramaDeParaOrgaoHistoricos(\Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico $fkOrganogramaDeParaOrgaoHistorico)
    {
        $this->fkOrganogramaDeParaOrgaoHistoricos->removeElement($fkOrganogramaDeParaOrgaoHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaDeParaOrgaoHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaOrgaoHistorico
     */
    public function getFkOrganogramaDeParaOrgaoHistoricos()
    {
        return $this->fkOrganogramaDeParaOrgaoHistoricos;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaNivel
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Nivel $fkOrganogramaNivel
     * @return Organograma
     */
    public function addFkOrganogramaNiveis(\Urbem\CoreBundle\Entity\Organograma\Nivel $fkOrganogramaNivel)
    {
        if (false === $this->fkOrganogramaNiveis->contains($fkOrganogramaNivel)) {
            $fkOrganogramaNivel->setFkOrganogramaOrganograma($this);
            $this->fkOrganogramaNiveis->add($fkOrganogramaNivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaNivel
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Nivel $fkOrganogramaNivel
     */
    public function removeFkOrganogramaNiveis(\Urbem\CoreBundle\Entity\Organograma\Nivel $fkOrganogramaNivel)
    {
        $this->fkOrganogramaNiveis->removeElement($fkOrganogramaNivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\Nivel
     */
    public function getFkOrganogramaNiveis()
    {
        return $this->fkOrganogramaNiveis;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection|Nivel $fkOrganogramaNiveis
     */
    public function setFkOrganogramaNiveis($fkOrganogramaNiveis)
    {
        $this->fkOrganogramaNiveis = $fkOrganogramaNiveis;
    }

    /**
     * OneToMany (owning side)
     * Add OrganogramaDeParaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaOrgao $fkOrganogramaDeParaOrgao
     * @return Organograma
     */
    public function addFkOrganogramaDeParaOrgoes(\Urbem\CoreBundle\Entity\Organograma\DeParaOrgao $fkOrganogramaDeParaOrgao)
    {
        if (false === $this->fkOrganogramaDeParaOrgoes->contains($fkOrganogramaDeParaOrgao)) {
            $fkOrganogramaDeParaOrgao->setFkOrganogramaOrganograma($this);
            $this->fkOrganogramaDeParaOrgoes->add($fkOrganogramaDeParaOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaDeParaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\DeParaOrgao $fkOrganogramaDeParaOrgao
     */
    public function removeFkOrganogramaDeParaOrgoes(\Urbem\CoreBundle\Entity\Organograma\DeParaOrgao $fkOrganogramaDeParaOrgao)
    {
        $this->fkOrganogramaDeParaOrgoes->removeElement($fkOrganogramaDeParaOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaDeParaOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\DeParaOrgao
     */
    public function getFkOrganogramaDeParaOrgoes()
    {
        return $this->fkOrganogramaDeParaOrgoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Organograma
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * @return int|string
     */
    public function getTipoNorma()
    {
        return (string) $this->fkNormasNorma->getFkNormasTipoNorma();
    }

    /**
     * @return int|string
     */
    public function getNorma()
    {
        return (string) $this->fkNormasNorma;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (is_null($this->getImplantacao()) || is_null($this->getCodOrganograma())) {
            return "Organograma";
        }

        return sprintf(
            '%s - %s',
            $this->getCodOrganograma(),
            $this->getImplantacao()->format('d/m/Y')
        );
    }
}
