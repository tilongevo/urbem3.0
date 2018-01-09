<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LicencaImovel
 */
class LicencaImovel
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelArea
     */
    private $fkImobiliarioLicencaImovelArea;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaConstrucao
     */
    private $fkImobiliarioLicencaImovelNovaConstrucao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaEdificacao
     */
    private $fkImobiliarioLicencaImovelNovaEdificacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeAutonoma
     */
    private $fkImobiliarioLicencaImovelUnidadeAutonomas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeDependente
     */
    private $fkImobiliarioLicencaImovelUnidadeDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor
     */
    private $fkImobiliarioAtributoTipoLicencaImovelValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Licenca
     */
    private $fkImobiliarioLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioLicencaImovelUnidadeAutonomas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaImovelUnidadeDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAtributoTipoLicencaImovelValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaImovel
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LicencaImovel
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return LicencaImovel
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaImovelUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeAutonoma $fkImobiliarioLicencaImovelUnidadeAutonoma
     * @return LicencaImovel
     */
    public function addFkImobiliarioLicencaImovelUnidadeAutonomas(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeAutonoma $fkImobiliarioLicencaImovelUnidadeAutonoma)
    {
        if (false === $this->fkImobiliarioLicencaImovelUnidadeAutonomas->contains($fkImobiliarioLicencaImovelUnidadeAutonoma)) {
            $fkImobiliarioLicencaImovelUnidadeAutonoma->setFkImobiliarioLicencaImovel($this);
            $this->fkImobiliarioLicencaImovelUnidadeAutonomas->add($fkImobiliarioLicencaImovelUnidadeAutonoma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaImovelUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeAutonoma $fkImobiliarioLicencaImovelUnidadeAutonoma
     */
    public function removeFkImobiliarioLicencaImovelUnidadeAutonomas(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeAutonoma $fkImobiliarioLicencaImovelUnidadeAutonoma)
    {
        $this->fkImobiliarioLicencaImovelUnidadeAutonomas->removeElement($fkImobiliarioLicencaImovelUnidadeAutonoma);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaImovelUnidadeAutonomas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeAutonoma
     */
    public function getFkImobiliarioLicencaImovelUnidadeAutonomas()
    {
        return $this->fkImobiliarioLicencaImovelUnidadeAutonomas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaImovelUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeDependente $fkImobiliarioLicencaImovelUnidadeDependente
     * @return LicencaImovel
     */
    public function addFkImobiliarioLicencaImovelUnidadeDependentes(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeDependente $fkImobiliarioLicencaImovelUnidadeDependente)
    {
        if (false === $this->fkImobiliarioLicencaImovelUnidadeDependentes->contains($fkImobiliarioLicencaImovelUnidadeDependente)) {
            $fkImobiliarioLicencaImovelUnidadeDependente->setFkImobiliarioLicencaImovel($this);
            $this->fkImobiliarioLicencaImovelUnidadeDependentes->add($fkImobiliarioLicencaImovelUnidadeDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaImovelUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeDependente $fkImobiliarioLicencaImovelUnidadeDependente
     */
    public function removeFkImobiliarioLicencaImovelUnidadeDependentes(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeDependente $fkImobiliarioLicencaImovelUnidadeDependente)
    {
        $this->fkImobiliarioLicencaImovelUnidadeDependentes->removeElement($fkImobiliarioLicencaImovelUnidadeDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaImovelUnidadeDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeDependente
     */
    public function getFkImobiliarioLicencaImovelUnidadeDependentes()
    {
        return $this->fkImobiliarioLicencaImovelUnidadeDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAtributoTipoLicencaImovelValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor $fkImobiliarioAtributoTipoLicencaImovelValor
     * @return LicencaImovel
     */
    public function addFkImobiliarioAtributoTipoLicencaImovelValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor $fkImobiliarioAtributoTipoLicencaImovelValor)
    {
        if (false === $this->fkImobiliarioAtributoTipoLicencaImovelValores->contains($fkImobiliarioAtributoTipoLicencaImovelValor)) {
            $fkImobiliarioAtributoTipoLicencaImovelValor->setFkImobiliarioLicencaImovel($this);
            $this->fkImobiliarioAtributoTipoLicencaImovelValores->add($fkImobiliarioAtributoTipoLicencaImovelValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoTipoLicencaImovelValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor $fkImobiliarioAtributoTipoLicencaImovelValor
     */
    public function removeFkImobiliarioAtributoTipoLicencaImovelValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor $fkImobiliarioAtributoTipoLicencaImovelValor)
    {
        $this->fkImobiliarioAtributoTipoLicencaImovelValores->removeElement($fkImobiliarioAtributoTipoLicencaImovelValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoTipoLicencaImovelValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor
     */
    public function getFkImobiliarioAtributoTipoLicencaImovelValores()
    {
        return $this->fkImobiliarioAtributoTipoLicencaImovelValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Licenca $fkImobiliarioLicenca
     * @return LicencaImovel
     */
    public function setFkImobiliarioLicenca(\Urbem\CoreBundle\Entity\Imobiliario\Licenca $fkImobiliarioLicenca)
    {
        $this->codLicenca = $fkImobiliarioLicenca->getCodLicenca();
        $this->exercicio = $fkImobiliarioLicenca->getExercicio();
        $this->fkImobiliarioLicenca = $fkImobiliarioLicenca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Licenca
     */
    public function getFkImobiliarioLicenca()
    {
        return $this->fkImobiliarioLicenca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return LicencaImovel
     */
    public function setFkImobiliarioImovel(\Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel)
    {
        $this->inscricaoMunicipal = $fkImobiliarioImovel->getInscricaoMunicipal();
        $this->fkImobiliarioImovel = $fkImobiliarioImovel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    public function getFkImobiliarioImovel()
    {
        return $this->fkImobiliarioImovel;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioLicencaImovelArea
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelArea $fkImobiliarioLicencaImovelArea
     * @return LicencaImovel
     */
    public function setFkImobiliarioLicencaImovelArea(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelArea $fkImobiliarioLicencaImovelArea)
    {
        $fkImobiliarioLicencaImovelArea->setFkImobiliarioLicencaImovel($this);
        $this->fkImobiliarioLicencaImovelArea = $fkImobiliarioLicencaImovelArea;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioLicencaImovelArea
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelArea
     */
    public function getFkImobiliarioLicencaImovelArea()
    {
        return $this->fkImobiliarioLicencaImovelArea;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioLicencaImovelNovaConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaConstrucao $fkImobiliarioLicencaImovelNovaConstrucao
     * @return LicencaImovel
     */
    public function setFkImobiliarioLicencaImovelNovaConstrucao(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaConstrucao $fkImobiliarioLicencaImovelNovaConstrucao)
    {
        $fkImobiliarioLicencaImovelNovaConstrucao->setFkImobiliarioLicencaImovel($this);
        $this->fkImobiliarioLicencaImovelNovaConstrucao = $fkImobiliarioLicencaImovelNovaConstrucao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioLicencaImovelNovaConstrucao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaConstrucao
     */
    public function getFkImobiliarioLicencaImovelNovaConstrucao()
    {
        return $this->fkImobiliarioLicencaImovelNovaConstrucao;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioLicencaImovelNovaEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaEdificacao $fkImobiliarioLicencaImovelNovaEdificacao
     * @return LicencaImovel
     */
    public function setFkImobiliarioLicencaImovelNovaEdificacao(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaEdificacao $fkImobiliarioLicencaImovelNovaEdificacao)
    {
        $fkImobiliarioLicencaImovelNovaEdificacao->setFkImobiliarioLicencaImovel($this);
        $this->fkImobiliarioLicencaImovelNovaEdificacao = $fkImobiliarioLicencaImovelNovaEdificacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioLicencaImovelNovaEdificacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaEdificacao
     */
    public function getFkImobiliarioLicencaImovelNovaEdificacao()
    {
        return $this->fkImobiliarioLicencaImovelNovaEdificacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkImobiliarioImovel;
    }
}
