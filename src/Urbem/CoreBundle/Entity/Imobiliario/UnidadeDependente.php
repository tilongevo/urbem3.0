<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * UnidadeDependente
 */
class UnidadeDependente
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
    private $codConstrucaoDependente;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeDependente
     */
    private $fkImobiliarioAreaUnidadeDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeDependente
     */
    private $fkImobiliarioBaixaUnidadeDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeDependente
     */
    private $fkImobiliarioLicencaImovelUnidadeDependentes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma
     */
    private $fkImobiliarioUnidadeAutonoma;

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
        $this->fkImobiliarioAreaUnidadeDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioBaixaUnidadeDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaImovelUnidadeDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return UnidadeDependente
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
     * Set codConstrucaoDependente
     *
     * @param integer $codConstrucaoDependente
     * @return UnidadeDependente
     */
    public function setCodConstrucaoDependente($codConstrucaoDependente)
    {
        $this->codConstrucaoDependente = $codConstrucaoDependente;
        return $this;
    }

    /**
     * Get codConstrucaoDependente
     *
     * @return integer
     */
    public function getCodConstrucaoDependente()
    {
        return $this->codConstrucaoDependente;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return UnidadeDependente
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
     * @return UnidadeDependente
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
     * @return UnidadeDependente
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
     * Add ImobiliarioAreaUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeDependente $fkImobiliarioAreaUnidadeDependente
     * @return UnidadeDependente
     */
    public function addFkImobiliarioAreaUnidadeDependentes(\Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeDependente $fkImobiliarioAreaUnidadeDependente)
    {
        if (false === $this->fkImobiliarioAreaUnidadeDependentes->contains($fkImobiliarioAreaUnidadeDependente)) {
            $fkImobiliarioAreaUnidadeDependente->setFkImobiliarioUnidadeDependente($this);
            $this->fkImobiliarioAreaUnidadeDependentes->add($fkImobiliarioAreaUnidadeDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAreaUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeDependente $fkImobiliarioAreaUnidadeDependente
     */
    public function removeFkImobiliarioAreaUnidadeDependentes(\Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeDependente $fkImobiliarioAreaUnidadeDependente)
    {
        $this->fkImobiliarioAreaUnidadeDependentes->removeElement($fkImobiliarioAreaUnidadeDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAreaUnidadeDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeDependente
     */
    public function getFkImobiliarioAreaUnidadeDependentes()
    {
        return $this->fkImobiliarioAreaUnidadeDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioBaixaUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeDependente $fkImobiliarioBaixaUnidadeDependente
     * @return UnidadeDependente
     */
    public function addFkImobiliarioBaixaUnidadeDependentes(\Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeDependente $fkImobiliarioBaixaUnidadeDependente)
    {
        if (false === $this->fkImobiliarioBaixaUnidadeDependentes->contains($fkImobiliarioBaixaUnidadeDependente)) {
            $fkImobiliarioBaixaUnidadeDependente->setFkImobiliarioUnidadeDependente($this);
            $this->fkImobiliarioBaixaUnidadeDependentes->add($fkImobiliarioBaixaUnidadeDependente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioBaixaUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeDependente $fkImobiliarioBaixaUnidadeDependente
     */
    public function removeFkImobiliarioBaixaUnidadeDependentes(\Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeDependente $fkImobiliarioBaixaUnidadeDependente)
    {
        $this->fkImobiliarioBaixaUnidadeDependentes->removeElement($fkImobiliarioBaixaUnidadeDependente);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioBaixaUnidadeDependentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeDependente
     */
    public function getFkImobiliarioBaixaUnidadeDependentes()
    {
        return $this->fkImobiliarioBaixaUnidadeDependentes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaImovelUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeDependente $fkImobiliarioLicencaImovelUnidadeDependente
     * @return UnidadeDependente
     */
    public function addFkImobiliarioLicencaImovelUnidadeDependentes(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeDependente $fkImobiliarioLicencaImovelUnidadeDependente)
    {
        if (false === $this->fkImobiliarioLicencaImovelUnidadeDependentes->contains($fkImobiliarioLicencaImovelUnidadeDependente)) {
            $fkImobiliarioLicencaImovelUnidadeDependente->setFkImobiliarioUnidadeDependente($this);
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioUnidadeAutonoma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma
     * @return UnidadeDependente
     */
    public function setFkImobiliarioUnidadeAutonoma(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma $fkImobiliarioUnidadeAutonoma)
    {
        $this->inscricaoMunicipal = $fkImobiliarioUnidadeAutonoma->getInscricaoMunicipal();
        $this->codTipo = $fkImobiliarioUnidadeAutonoma->getCodTipo();
        $this->codConstrucao = $fkImobiliarioUnidadeAutonoma->getCodConstrucao();
        $this->fkImobiliarioUnidadeAutonoma = $fkImobiliarioUnidadeAutonoma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioUnidadeAutonoma
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma
     */
    public function getFkImobiliarioUnidadeAutonoma()
    {
        return $this->fkImobiliarioUnidadeAutonoma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao
     * @return UnidadeDependente
     */
    public function setFkImobiliarioConstrucao(\Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao)
    {
        $this->codConstrucaoDependente = $fkImobiliarioConstrucao->getCodConstrucao();
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
