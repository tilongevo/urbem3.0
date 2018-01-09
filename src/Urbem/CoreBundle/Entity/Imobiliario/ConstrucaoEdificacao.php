<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ConstrucaoEdificacao
 */
class ConstrucaoEdificacao
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor
     */
    private $fkImobiliarioAtributoTipoEdificacaoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaEdificacao
     */
    private $fkImobiliarioLicencaImovelNovaEdificacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma
     */
    private $fkImobiliarioUnidadeAutonomas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao
     */
    private $fkImobiliarioTipoEdificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    private $fkImobiliarioConstrucao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAtributoTipoEdificacaoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaImovelNovaEdificacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioUnidadeAutonomas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ConstrucaoEdificacao
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return ConstrucaoEdificacao
     */
    public function setCodConstrucao($codConstrucao)
    {
        $this->codConstrucao = $codConstrucao;
        return $this;
    }

    /**
     * Get codConstrucao
     *
     * @return integer
     */
    public function getCodConstrucao()
    {
        return $this->codConstrucao;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoTipoEdificacaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor $fkImobiliarioAtributoTipoEdificacaoValor
     * @return ConstrucaoEdificacao
     */
    public function addFkImobiliarioAtributoTipoEdificacaoValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor $fkImobiliarioAtributoTipoEdificacaoValor)
    {
        if (false === $this->fkImobiliarioAtributoTipoEdificacaoValores->contains($fkImobiliarioAtributoTipoEdificacaoValor)) {
            $fkImobiliarioAtributoTipoEdificacaoValor->setFkImobiliarioConstrucaoEdificacao($this);
            $this->fkImobiliarioAtributoTipoEdificacaoValores->add($fkImobiliarioAtributoTipoEdificacaoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoTipoEdificacaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor $fkImobiliarioAtributoTipoEdificacaoValor
     */
    public function removeFkImobiliarioAtributoTipoEdificacaoValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor $fkImobiliarioAtributoTipoEdificacaoValor)
    {
        $this->fkImobiliarioAtributoTipoEdificacaoValores->removeElement($fkImobiliarioAtributoTipoEdificacaoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoTipoEdificacaoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor
     */
    public function getFkImobiliarioAtributoTipoEdificacaoValores()
    {
        return $this->fkImobiliarioAtributoTipoEdificacaoValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaImovelNovaEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaEdificacao $fkImobiliarioLicencaImovelNovaEdificacao
     * @return ConstrucaoEdificacao
     */
    public function addFkImobiliarioLicencaImovelNovaEdificacoes(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaEdificacao $fkImobiliarioLicencaImovelNovaEdificacao)
    {
        if (false === $this->fkImobiliarioLicencaImovelNovaEdificacoes->contains($fkImobiliarioLicencaImovelNovaEdificacao)) {
            $fkImobiliarioLicencaImovelNovaEdificacao->setFkImobiliarioConstrucaoEdificacao($this);
            $this->fkImobiliarioLicencaImovelNovaEdificacoes->add($fkImobiliarioLicencaImovelNovaEdificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaImovelNovaEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaEdificacao $fkImobiliarioLicencaImovelNovaEdificacao
     */
    public function removeFkImobiliarioLicencaImovelNovaEdificacoes(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaEdificacao $fkImobiliarioLicencaImovelNovaEdificacao)
    {
        $this->fkImobiliarioLicencaImovelNovaEdificacoes->removeElement($fkImobiliarioLicencaImovelNovaEdificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaImovelNovaEdificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaEdificacao
     */
    public function getFkImobiliarioLicencaImovelNovaEdificacoes()
    {
        return $this->fkImobiliarioLicencaImovelNovaEdificacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma
     * @return ConstrucaoEdificacao
     */
    public function addFkImobiliarioUnidadeAutonomas(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma)
    {
        if (false === $this->fkImobiliarioUnidadeAutonomas->contains($fkImobiliarioUnidadeAutonoma)) {
            $fkImobiliarioUnidadeAutonoma->setFkImobiliarioConstrucaoEdificacao($this);
            $this->fkImobiliarioUnidadeAutonomas->add($fkImobiliarioUnidadeAutonoma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma
     */
    public function removeFkImobiliarioUnidadeAutonomas(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma)
    {
        $this->fkImobiliarioUnidadeAutonomas->removeElement($fkImobiliarioUnidadeAutonoma);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioUnidadeAutonomas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma
     */
    public function getFkImobiliarioUnidadeAutonomas()
    {
        return $this->fkImobiliarioUnidadeAutonomas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioTipoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao $fkImobiliarioTipoEdificacao
     * @return ConstrucaoEdificacao
     */
    public function setFkImobiliarioTipoEdificacao(\Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao $fkImobiliarioTipoEdificacao)
    {
        $this->codTipo = $fkImobiliarioTipoEdificacao->getCodTipo();
        $this->fkImobiliarioTipoEdificacao = $fkImobiliarioTipoEdificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioTipoEdificacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao
     */
    public function getFkImobiliarioTipoEdificacao()
    {
        return $this->fkImobiliarioTipoEdificacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao
     * @return ConstrucaoEdificacao
     */
    public function setFkImobiliarioConstrucao(\Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao)
    {
        $this->codConstrucao = $fkImobiliarioConstrucao->getCodConstrucao();
        $this->fkImobiliarioConstrucao = $fkImobiliarioConstrucao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioConstrucao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    public function getFkImobiliarioConstrucao()
    {
        return $this->fkImobiliarioConstrucao;
    }
}
