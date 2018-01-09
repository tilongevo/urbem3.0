<?php
 
namespace Urbem\CoreBundle\Entity\Organograma;

/**
 * Nivel
 */
class Nivel
{
    /**
     * PK
     * @var integer
     */
    private $codNivel;

    /**
     * PK
     * @var integer
     */
    private $codOrganograma;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $mascaracodigo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\OrganogramaNivel
     */
    private $fkOrcamentoOrganogramaNiveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\OrgaoNivel
     */
    private $fkOrganogramaOrgaoNiveis;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Organograma
     */
    private $fkOrganogramaOrganograma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoOrganogramaNiveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrganogramaOrgaoNiveis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return Nivel
     */
    public function setCodNivel($codNivel)
    {
        $this->codNivel = $codNivel;
        return $this;
    }

    /**
     * Get codNivel
     *
     * @return integer
     */
    public function getCodNivel()
    {
        return $this->codNivel;
    }

    /**
     * Set codOrganograma
     *
     * @param integer $codOrganograma
     * @return Nivel
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
     * Set descricao
     *
     * @param string $descricao
     * @return Nivel
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
     * Set mascaracodigo
     *
     * @param string $mascaracodigo
     * @return Nivel
     */
    public function setMascaracodigo($mascaracodigo)
    {
        $this->mascaracodigo = $mascaracodigo;
        return $this;
    }

    /**
     * Get mascaracodigo
     *
     * @return string
     */
    public function getMascaracodigo()
    {
        return $this->mascaracodigo;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoOrganogramaNivel
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\OrganogramaNivel $fkOrcamentoOrganogramaNivel
     * @return Nivel
     */
    public function addFkOrcamentoOrganogramaNiveis(\Urbem\CoreBundle\Entity\Orcamento\OrganogramaNivel $fkOrcamentoOrganogramaNivel)
    {
        if (false === $this->fkOrcamentoOrganogramaNiveis->contains($fkOrcamentoOrganogramaNivel)) {
            $fkOrcamentoOrganogramaNivel->setFkOrganogramaNivel($this);
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
     * Add OrganogramaOrgaoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\OrgaoNivel $fkOrganogramaOrgaoNivel
     * @return Nivel
     */
    public function addFkOrganogramaOrgaoNiveis(\Urbem\CoreBundle\Entity\Organograma\OrgaoNivel $fkOrganogramaOrgaoNivel)
    {
        if (false === $this->fkOrganogramaOrgaoNiveis->contains($fkOrganogramaOrgaoNivel)) {
            $fkOrganogramaOrgaoNivel->setFkOrganogramaNivel($this);
            $this->fkOrganogramaOrgaoNiveis->add($fkOrganogramaOrgaoNivel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrganogramaOrgaoNivel
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\OrgaoNivel $fkOrganogramaOrgaoNivel
     */
    public function removeFkOrganogramaOrgaoNiveis(\Urbem\CoreBundle\Entity\Organograma\OrgaoNivel $fkOrganogramaOrgaoNivel)
    {
        $this->fkOrganogramaOrgaoNiveis->removeElement($fkOrganogramaOrgaoNivel);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrganogramaOrgaoNiveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Organograma\OrgaoNivel
     */
    public function getFkOrganogramaOrgaoNiveis()
    {
        return $this->fkOrganogramaOrgaoNiveis;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrganograma
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Organograma $fkOrganogramaOrganograma
     * @return Nivel
     */
    public function setFkOrganogramaOrganograma(\Urbem\CoreBundle\Entity\Organograma\Organograma $fkOrganogramaOrganograma)
    {
        $this->codOrganograma = $fkOrganogramaOrganograma->getCodOrganograma();
        $this->fkOrganogramaOrganograma = $fkOrganogramaOrganograma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrganograma
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Organograma
     */
    public function getFkOrganogramaOrganograma()
    {
        return $this->fkOrganogramaOrganograma;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%d - %s', $this->getCodNivel(), $this->getDescricao());
    }
}
