<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * UnidadeAutonoma
 */
class UnidadeAutonoma
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

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
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeAutonoma
     */
    private $fkImobiliarioAreaUnidadeAutonomas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeAutonoma
     */
    private $fkImobiliarioBaixaUnidadeAutonomas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeAutonoma
     */
    private $fkImobiliarioLicencaImovelUnidadeAutonomas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente
     */
    private $fkImobiliarioUnidadeDependentes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao
     */
    private $fkImobiliarioConstrucaoEdificacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAreaUnidadeAutonomas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioBaixaUnidadeAutonomas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaImovelUnidadeAutonomas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioUnidadeDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return UnidadeAutonoma
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return UnidadeAutonoma
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
     * @return UnidadeAutonoma
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return UnidadeAutonoma
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
     * Add ImobiliarioAreaUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeAutonoma $fkImobiliarioAreaUnidadeAutonoma
     * @return UnidadeAutonoma
     */
    public function addFkImobiliarioAreaUnidadeAutonomas(\Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeAutonoma $fkImobiliarioAreaUnidadeAutonoma)
    {
        if (false === $this->fkImobiliarioAreaUnidadeAutonomas->contains($fkImobiliarioAreaUnidadeAutonoma)) {
            $fkImobiliarioAreaUnidadeAutonoma->setFkImobiliarioUnidadeAutonoma($this);
            $this->fkImobiliarioAreaUnidadeAutonomas->add($fkImobiliarioAreaUnidadeAutonoma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAreaUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeAutonoma $fkImobiliarioAreaUnidadeAutonoma
     */
    public function removeFkImobiliarioAreaUnidadeAutonomas(\Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeAutonoma $fkImobiliarioAreaUnidadeAutonoma)
    {
        $this->fkImobiliarioAreaUnidadeAutonomas->removeElement($fkImobiliarioAreaUnidadeAutonoma);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAreaUnidadeAutonomas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeAutonoma
     */
    public function getFkImobiliarioAreaUnidadeAutonomas()
    {
        return $this->fkImobiliarioAreaUnidadeAutonomas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioBaixaUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeAutonoma $fkImobiliarioBaixaUnidadeAutonoma
     * @return UnidadeAutonoma
     */
    public function addFkImobiliarioBaixaUnidadeAutonomas(\Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeAutonoma $fkImobiliarioBaixaUnidadeAutonoma)
    {
        if (false === $this->fkImobiliarioBaixaUnidadeAutonomas->contains($fkImobiliarioBaixaUnidadeAutonoma)) {
            $fkImobiliarioBaixaUnidadeAutonoma->setFkImobiliarioUnidadeAutonoma($this);
            $this->fkImobiliarioBaixaUnidadeAutonomas->add($fkImobiliarioBaixaUnidadeAutonoma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioBaixaUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeAutonoma $fkImobiliarioBaixaUnidadeAutonoma
     */
    public function removeFkImobiliarioBaixaUnidadeAutonomas(\Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeAutonoma $fkImobiliarioBaixaUnidadeAutonoma)
    {
        $this->fkImobiliarioBaixaUnidadeAutonomas->removeElement($fkImobiliarioBaixaUnidadeAutonoma);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioBaixaUnidadeAutonomas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeAutonoma
     */
    public function getFkImobiliarioBaixaUnidadeAutonomas()
    {
        return $this->fkImobiliarioBaixaUnidadeAutonomas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaImovelUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeAutonoma $fkImobiliarioLicencaImovelUnidadeAutonoma
     * @return UnidadeAutonoma
     */
    public function addFkImobiliarioLicencaImovelUnidadeAutonomas(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeAutonoma $fkImobiliarioLicencaImovelUnidadeAutonoma)
    {
        if (false === $this->fkImobiliarioLicencaImovelUnidadeAutonomas->contains($fkImobiliarioLicencaImovelUnidadeAutonoma)) {
            $fkImobiliarioLicencaImovelUnidadeAutonoma->setFkImobiliarioUnidadeAutonoma($this);
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
     * Add ImobiliarioUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente $fkImobiliarioUnidadeDependente
     * @return UnidadeAutonoma
     */
    public function addFkImobiliarioUnidadeDependentes(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente $fkImobiliarioUnidadeDependente)
    {
        if (false === $this->fkImobiliarioUnidadeDependentes->contains($fkImobiliarioUnidadeDependente)) {
            $fkImobiliarioUnidadeDependente->setFkImobiliarioUnidadeAutonoma($this);
            $this->fkImobiliarioUnidadeDependentes->add($fkImobiliarioUnidadeDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente $fkImobiliarioUnidadeDependente
     */
    public function removeFkImobiliarioUnidadeDependentes(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente $fkImobiliarioUnidadeDependente)
    {
        $this->fkImobiliarioUnidadeDependentes->removeElement($fkImobiliarioUnidadeDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioUnidadeDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente
     */
    public function getFkImobiliarioUnidadeDependentes()
    {
        return $this->fkImobiliarioUnidadeDependentes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return UnidadeAutonoma
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioConstrucaoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao
     * @return UnidadeAutonoma
     */
    public function setFkImobiliarioConstrucaoEdificacao(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao)
    {
        $this->codTipo = $fkImobiliarioConstrucaoEdificacao->getCodTipo();
        $this->codConstrucao = $fkImobiliarioConstrucaoEdificacao->getCodConstrucao();
        $this->fkImobiliarioConstrucaoEdificacao = $fkImobiliarioConstrucaoEdificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioConstrucaoEdificacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao
     */
    public function getFkImobiliarioConstrucaoEdificacao()
    {
        return $this->fkImobiliarioConstrucaoEdificacao;
    }
}
