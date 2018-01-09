<?php
 
namespace Urbem\CoreBundle\Entity\Ldo;

/**
 * Ldo
 */
class Ldo
{
    /**
     * PK
     * @var integer
     */
    private $codPpa;

    /**
     * PK
     * @var string
     */
    private $ano;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\CompensacaoRenuncia
     */
    private $fkLdoCompensacaoRenuncias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida
     */
    private $fkLdoConfiguracaoDividas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoEvolucaoPatrimonioLiquido
     */
    private $fkLdoConfiguracaoEvolucaoPatrimonioLiquidos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoReceitaDespesa
     */
    private $fkLdoConfiguracaoReceitaDespesas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\Homologacao
     */
    private $fkLdoHomologacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Ppa
     */
    private $fkPpaPpa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLdoCompensacaoRenuncias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLdoConfiguracaoDividas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLdoConfiguracaoEvolucaoPatrimonioLiquidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLdoConfiguracaoReceitaDespesas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLdoHomologacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codPpa
     *
     * @param integer $codPpa
     * @return Ldo
     */
    public function setCodPpa($codPpa)
    {
        $this->codPpa = $codPpa;
        return $this;
    }

    /**
     * Get codPpa
     *
     * @return integer
     */
    public function getCodPpa()
    {
        return $this->codPpa;
    }

    /**
     * Set ano
     *
     * @param string $ano
     * @return Ldo
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Ldo
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add LdoCompensacaoRenuncia
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\CompensacaoRenuncia $fkLdoCompensacaoRenuncia
     * @return Ldo
     */
    public function addFkLdoCompensacaoRenuncias(\Urbem\CoreBundle\Entity\Ldo\CompensacaoRenuncia $fkLdoCompensacaoRenuncia)
    {
        if (false === $this->fkLdoCompensacaoRenuncias->contains($fkLdoCompensacaoRenuncia)) {
            $fkLdoCompensacaoRenuncia->setFkLdoLdo($this);
            $this->fkLdoCompensacaoRenuncias->add($fkLdoCompensacaoRenuncia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoCompensacaoRenuncia
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\CompensacaoRenuncia $fkLdoCompensacaoRenuncia
     */
    public function removeFkLdoCompensacaoRenuncias(\Urbem\CoreBundle\Entity\Ldo\CompensacaoRenuncia $fkLdoCompensacaoRenuncia)
    {
        $this->fkLdoCompensacaoRenuncias->removeElement($fkLdoCompensacaoRenuncia);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoCompensacaoRenuncias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\CompensacaoRenuncia
     */
    public function getFkLdoCompensacaoRenuncias()
    {
        return $this->fkLdoCompensacaoRenuncias;
    }

    /**
     * OneToMany (owning side)
     * Add LdoConfiguracaoDivida
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida $fkLdoConfiguracaoDivida
     * @return Ldo
     */
    public function addFkLdoConfiguracaoDividas(\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida $fkLdoConfiguracaoDivida)
    {
        if (false === $this->fkLdoConfiguracaoDividas->contains($fkLdoConfiguracaoDivida)) {
            $fkLdoConfiguracaoDivida->setFkLdoLdo($this);
            $this->fkLdoConfiguracaoDividas->add($fkLdoConfiguracaoDivida);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoConfiguracaoDivida
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida $fkLdoConfiguracaoDivida
     */
    public function removeFkLdoConfiguracaoDividas(\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida $fkLdoConfiguracaoDivida)
    {
        $this->fkLdoConfiguracaoDividas->removeElement($fkLdoConfiguracaoDivida);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoConfiguracaoDividas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida
     */
    public function getFkLdoConfiguracaoDividas()
    {
        return $this->fkLdoConfiguracaoDividas;
    }

    /**
     * OneToMany (owning side)
     * Add LdoConfiguracaoEvolucaoPatrimonioLiquido
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\ConfiguracaoEvolucaoPatrimonioLiquido $fkLdoConfiguracaoEvolucaoPatrimonioLiquido
     * @return Ldo
     */
    public function addFkLdoConfiguracaoEvolucaoPatrimonioLiquidos(\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoEvolucaoPatrimonioLiquido $fkLdoConfiguracaoEvolucaoPatrimonioLiquido)
    {
        if (false === $this->fkLdoConfiguracaoEvolucaoPatrimonioLiquidos->contains($fkLdoConfiguracaoEvolucaoPatrimonioLiquido)) {
            $fkLdoConfiguracaoEvolucaoPatrimonioLiquido->setFkLdoLdo($this);
            $this->fkLdoConfiguracaoEvolucaoPatrimonioLiquidos->add($fkLdoConfiguracaoEvolucaoPatrimonioLiquido);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoConfiguracaoEvolucaoPatrimonioLiquido
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\ConfiguracaoEvolucaoPatrimonioLiquido $fkLdoConfiguracaoEvolucaoPatrimonioLiquido
     */
    public function removeFkLdoConfiguracaoEvolucaoPatrimonioLiquidos(\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoEvolucaoPatrimonioLiquido $fkLdoConfiguracaoEvolucaoPatrimonioLiquido)
    {
        $this->fkLdoConfiguracaoEvolucaoPatrimonioLiquidos->removeElement($fkLdoConfiguracaoEvolucaoPatrimonioLiquido);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoConfiguracaoEvolucaoPatrimonioLiquidos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoEvolucaoPatrimonioLiquido
     */
    public function getFkLdoConfiguracaoEvolucaoPatrimonioLiquidos()
    {
        return $this->fkLdoConfiguracaoEvolucaoPatrimonioLiquidos;
    }

    /**
     * OneToMany (owning side)
     * Add LdoConfiguracaoReceitaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\ConfiguracaoReceitaDespesa $fkLdoConfiguracaoReceitaDespesa
     * @return Ldo
     */
    public function addFkLdoConfiguracaoReceitaDespesas(\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoReceitaDespesa $fkLdoConfiguracaoReceitaDespesa)
    {
        if (false === $this->fkLdoConfiguracaoReceitaDespesas->contains($fkLdoConfiguracaoReceitaDespesa)) {
            $fkLdoConfiguracaoReceitaDespesa->setFkLdoLdo($this);
            $this->fkLdoConfiguracaoReceitaDespesas->add($fkLdoConfiguracaoReceitaDespesa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoConfiguracaoReceitaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\ConfiguracaoReceitaDespesa $fkLdoConfiguracaoReceitaDespesa
     */
    public function removeFkLdoConfiguracaoReceitaDespesas(\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoReceitaDespesa $fkLdoConfiguracaoReceitaDespesa)
    {
        $this->fkLdoConfiguracaoReceitaDespesas->removeElement($fkLdoConfiguracaoReceitaDespesa);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoConfiguracaoReceitaDespesas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\ConfiguracaoReceitaDespesa
     */
    public function getFkLdoConfiguracaoReceitaDespesas()
    {
        return $this->fkLdoConfiguracaoReceitaDespesas;
    }

    /**
     * OneToMany (owning side)
     * Add LdoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao
     * @return Ldo
     */
    public function addFkLdoHomologacoes(\Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao)
    {
        if (false === $this->fkLdoHomologacoes->contains($fkLdoHomologacao)) {
            $fkLdoHomologacao->setFkLdoLdo($this);
            $this->fkLdoHomologacoes->add($fkLdoHomologacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao
     */
    public function removeFkLdoHomologacoes(\Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao)
    {
        $this->fkLdoHomologacoes->removeElement($fkLdoHomologacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoHomologacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\Homologacao
     */
    public function getFkLdoHomologacoes()
    {
        return $this->fkLdoHomologacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaPpa
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Ppa $fkPpaPpa
     * @return Ldo
     */
    public function setFkPpaPpa(\Urbem\CoreBundle\Entity\Ppa\Ppa $fkPpaPpa)
    {
        $this->codPpa = $fkPpaPpa->getCodPpa();
        $this->fkPpaPpa = $fkPpaPpa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaPpa
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Ppa
     */
    public function getFkPpaPpa()
    {
        return $this->fkPpaPpa;
    }
}
