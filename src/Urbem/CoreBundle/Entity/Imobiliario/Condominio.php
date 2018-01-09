<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Condominio
 */
class Condominio
{
    /**
     * PK
     * @var integer
     */
    private $codCondominio;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomCondominio;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor
     */
    private $fkImobiliarioAtributoCondominioValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio
     */
    private $fkImobiliarioLoteCondominios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoCondominio
     */
    private $fkImobiliarioConstrucaoCondominios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso
     */
    private $fkImobiliarioCondominioProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\CondominioAreaComum
     */
    private $fkImobiliarioCondominioAreaComuns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\CondominioCgm
     */
    private $fkImobiliarioCondominioCgns;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelCondominio
     */
    private $fkImobiliarioImovelCondominios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TipoCondominio
     */
    private $fkImobiliarioTipoCondominio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAtributoCondominioValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLoteCondominios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioConstrucaoCondominios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioCondominioProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioCondominioAreaComuns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioCondominioCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioImovelCondominios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCondominio
     *
     * @param integer $codCondominio
     * @return Condominio
     */
    public function setCodCondominio($codCondominio)
    {
        $this->codCondominio = $codCondominio;
        return $this;
    }

    /**
     * Get codCondominio
     *
     * @return integer
     */
    public function getCodCondominio()
    {
        return $this->codCondominio;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Condominio
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
     * Set nomCondominio
     *
     * @param string $nomCondominio
     * @return Condominio
     */
    public function setNomCondominio($nomCondominio)
    {
        $this->nomCondominio = $nomCondominio;
        return $this;
    }

    /**
     * Get nomCondominio
     *
     * @return string
     */
    public function getNomCondominio()
    {
        return $this->nomCondominio;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Condominio
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp = null)
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
     * Add ImobiliarioAtributoCondominioValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor $fkImobiliarioAtributoCondominioValor
     * @return Condominio
     */
    public function addFkImobiliarioAtributoCondominioValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor $fkImobiliarioAtributoCondominioValor)
    {
        if (false === $this->fkImobiliarioAtributoCondominioValores->contains($fkImobiliarioAtributoCondominioValor)) {
            $fkImobiliarioAtributoCondominioValor->setFkImobiliarioCondominio($this);
            $this->fkImobiliarioAtributoCondominioValores->add($fkImobiliarioAtributoCondominioValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoCondominioValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor $fkImobiliarioAtributoCondominioValor
     */
    public function removeFkImobiliarioAtributoCondominioValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor $fkImobiliarioAtributoCondominioValor)
    {
        $this->fkImobiliarioAtributoCondominioValores->removeElement($fkImobiliarioAtributoCondominioValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoCondominioValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoCondominioValor
     */
    public function getFkImobiliarioAtributoCondominioValores()
    {
        return $this->fkImobiliarioAtributoCondominioValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLoteCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio $fkImobiliarioLoteCondominio
     * @return Condominio
     */
    public function addFkImobiliarioLoteCondominios(\Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio $fkImobiliarioLoteCondominio)
    {
        if (false === $this->fkImobiliarioLoteCondominios->contains($fkImobiliarioLoteCondominio)) {
            $fkImobiliarioLoteCondominio->setFkImobiliarioCondominio($this);
            $this->fkImobiliarioLoteCondominios->add($fkImobiliarioLoteCondominio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLoteCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio $fkImobiliarioLoteCondominio
     */
    public function removeFkImobiliarioLoteCondominios(\Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio $fkImobiliarioLoteCondominio)
    {
        $this->fkImobiliarioLoteCondominios->removeElement($fkImobiliarioLoteCondominio);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLoteCondominios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio
     */
    public function getFkImobiliarioLoteCondominios()
    {
        return $this->fkImobiliarioLoteCondominios;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioConstrucaoCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoCondominio $fkImobiliarioConstrucaoCondominio
     * @return Condominio
     */
    public function addFkImobiliarioConstrucaoCondominios(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoCondominio $fkImobiliarioConstrucaoCondominio)
    {
        if (false === $this->fkImobiliarioConstrucaoCondominios->contains($fkImobiliarioConstrucaoCondominio)) {
            $fkImobiliarioConstrucaoCondominio->setFkImobiliarioCondominio($this);
            $this->fkImobiliarioConstrucaoCondominios->add($fkImobiliarioConstrucaoCondominio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioConstrucaoCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoCondominio $fkImobiliarioConstrucaoCondominio
     */
    public function removeFkImobiliarioConstrucaoCondominios(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoCondominio $fkImobiliarioConstrucaoCondominio)
    {
        $this->fkImobiliarioConstrucaoCondominios->removeElement($fkImobiliarioConstrucaoCondominio);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioConstrucaoCondominios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoCondominio
     */
    public function getFkImobiliarioConstrucaoCondominios()
    {
        return $this->fkImobiliarioConstrucaoCondominios;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioCondominioProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso $fkImobiliarioCondominioProcesso
     * @return Condominio
     */
    public function addFkImobiliarioCondominioProcessos(\Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso $fkImobiliarioCondominioProcesso)
    {
        if (false === $this->fkImobiliarioCondominioProcessos->contains($fkImobiliarioCondominioProcesso)) {
            $fkImobiliarioCondominioProcesso->setFkImobiliarioCondominio($this);
            $this->fkImobiliarioCondominioProcessos->add($fkImobiliarioCondominioProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioCondominioProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso $fkImobiliarioCondominioProcesso
     */
    public function removeFkImobiliarioCondominioProcessos(\Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso $fkImobiliarioCondominioProcesso)
    {
        $this->fkImobiliarioCondominioProcessos->removeElement($fkImobiliarioCondominioProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioCondominioProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso
     */
    public function getFkImobiliarioCondominioProcessos()
    {
        return $this->fkImobiliarioCondominioProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioCondominioAreaComum
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\CondominioAreaComum $fkImobiliarioCondominioAreaComum
     * @return Condominio
     */
    public function addFkImobiliarioCondominioAreaComuns(\Urbem\CoreBundle\Entity\Imobiliario\CondominioAreaComum $fkImobiliarioCondominioAreaComum)
    {
        if (false === $this->fkImobiliarioCondominioAreaComuns->contains($fkImobiliarioCondominioAreaComum)) {
            $fkImobiliarioCondominioAreaComum->setFkImobiliarioCondominio($this);
            $this->fkImobiliarioCondominioAreaComuns->add($fkImobiliarioCondominioAreaComum);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioCondominioAreaComum
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\CondominioAreaComum $fkImobiliarioCondominioAreaComum
     */
    public function removeFkImobiliarioCondominioAreaComuns(\Urbem\CoreBundle\Entity\Imobiliario\CondominioAreaComum $fkImobiliarioCondominioAreaComum)
    {
        $this->fkImobiliarioCondominioAreaComuns->removeElement($fkImobiliarioCondominioAreaComum);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioCondominioAreaComuns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\CondominioAreaComum
     */
    public function getFkImobiliarioCondominioAreaComuns()
    {
        return $this->fkImobiliarioCondominioAreaComuns;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioCondominioCgm
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\CondominioCgm $fkImobiliarioCondominioCgm
     * @return Condominio
     */
    public function addFkImobiliarioCondominioCgns(\Urbem\CoreBundle\Entity\Imobiliario\CondominioCgm $fkImobiliarioCondominioCgm)
    {
        if (false === $this->fkImobiliarioCondominioCgns->contains($fkImobiliarioCondominioCgm)) {
            $fkImobiliarioCondominioCgm->setFkImobiliarioCondominio($this);
            $this->fkImobiliarioCondominioCgns->add($fkImobiliarioCondominioCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioCondominioCgm
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\CondominioCgm $fkImobiliarioCondominioCgm
     */
    public function removeFkImobiliarioCondominioCgns(\Urbem\CoreBundle\Entity\Imobiliario\CondominioCgm $fkImobiliarioCondominioCgm)
    {
        $this->fkImobiliarioCondominioCgns->removeElement($fkImobiliarioCondominioCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioCondominioCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\CondominioCgm
     */
    public function getFkImobiliarioCondominioCgns()
    {
        return $this->fkImobiliarioCondominioCgns;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioImovelCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelCondominio $fkImobiliarioImovelCondominio
     * @return Condominio
     */
    public function addFkImobiliarioImovelCondominios(\Urbem\CoreBundle\Entity\Imobiliario\ImovelCondominio $fkImobiliarioImovelCondominio)
    {
        if (false === $this->fkImobiliarioImovelCondominios->contains($fkImobiliarioImovelCondominio)) {
            $fkImobiliarioImovelCondominio->setFkImobiliarioCondominio($this);
            $this->fkImobiliarioImovelCondominios->add($fkImobiliarioImovelCondominio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioImovelCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelCondominio $fkImobiliarioImovelCondominio
     */
    public function removeFkImobiliarioImovelCondominios(\Urbem\CoreBundle\Entity\Imobiliario\ImovelCondominio $fkImobiliarioImovelCondominio)
    {
        $this->fkImobiliarioImovelCondominios->removeElement($fkImobiliarioImovelCondominio);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioImovelCondominios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelCondominio
     */
    public function getFkImobiliarioImovelCondominios()
    {
        return $this->fkImobiliarioImovelCondominios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioTipoCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoCondominio $fkImobiliarioTipoCondominio
     * @return Condominio
     */
    public function setFkImobiliarioTipoCondominio(\Urbem\CoreBundle\Entity\Imobiliario\TipoCondominio $fkImobiliarioTipoCondominio)
    {
        $this->codTipo = $fkImobiliarioTipoCondominio->getCodTipo();
        $this->fkImobiliarioTipoCondominio = $fkImobiliarioTipoCondominio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioTipoCondominio
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TipoCondominio
     */
    public function getFkImobiliarioTipoCondominio()
    {
        return $this->fkImobiliarioTipoCondominio;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codCondominio, $this->nomCondominio);
    }
}
