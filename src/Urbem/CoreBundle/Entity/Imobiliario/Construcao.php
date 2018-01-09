<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Construcao
 */
class Construcao
{
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
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoOutros
     */
    private $fkImobiliarioConstrucaoOutros;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\DataConstrucao
     */
    private $fkImobiliarioDataConstrucao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AreaConstrucao
     */
    private $fkImobiliarioAreaConstrucoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaConstrucao
     */
    private $fkImobiliarioBaixaConstrucoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReforma
     */
    private $fkImobiliarioConstrucaoReformas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso
     */
    private $fkImobiliarioConstrucaoProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaConstrucao
     */
    private $fkImobiliarioLicencaImovelNovaConstrucoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente
     */
    private $fkImobiliarioUnidadeDependentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao
     */
    private $fkImobiliarioConstrucaoEdificacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoCondominio
     */
    private $fkImobiliarioConstrucaoCondominios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAreaConstrucoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioBaixaConstrucoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioConstrucaoReformas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioConstrucaoProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaImovelNovaConstrucoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioUnidadeDependentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioConstrucaoEdificacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioConstrucaoCondominios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return Construcao
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
     * @return Construcao
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
     * Add ImobiliarioAreaConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AreaConstrucao $fkImobiliarioAreaConstrucao
     * @return Construcao
     */
    public function addFkImobiliarioAreaConstrucoes(\Urbem\CoreBundle\Entity\Imobiliario\AreaConstrucao $fkImobiliarioAreaConstrucao)
    {
        if (false === $this->fkImobiliarioAreaConstrucoes->contains($fkImobiliarioAreaConstrucao)) {
            $fkImobiliarioAreaConstrucao->setFkImobiliarioConstrucao($this);
            $this->fkImobiliarioAreaConstrucoes->add($fkImobiliarioAreaConstrucao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAreaConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AreaConstrucao $fkImobiliarioAreaConstrucao
     */
    public function removeFkImobiliarioAreaConstrucoes(\Urbem\CoreBundle\Entity\Imobiliario\AreaConstrucao $fkImobiliarioAreaConstrucao)
    {
        $this->fkImobiliarioAreaConstrucoes->removeElement($fkImobiliarioAreaConstrucao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAreaConstrucoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AreaConstrucao
     */
    public function getFkImobiliarioAreaConstrucoes()
    {
        return $this->fkImobiliarioAreaConstrucoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioBaixaConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaConstrucao $fkImobiliarioBaixaConstrucao
     * @return Construcao
     */
    public function addFkImobiliarioBaixaConstrucoes(\Urbem\CoreBundle\Entity\Imobiliario\BaixaConstrucao $fkImobiliarioBaixaConstrucao)
    {
        if (false === $this->fkImobiliarioBaixaConstrucoes->contains($fkImobiliarioBaixaConstrucao)) {
            $fkImobiliarioBaixaConstrucao->setFkImobiliarioConstrucao($this);
            $this->fkImobiliarioBaixaConstrucoes->add($fkImobiliarioBaixaConstrucao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioBaixaConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaConstrucao $fkImobiliarioBaixaConstrucao
     */
    public function removeFkImobiliarioBaixaConstrucoes(\Urbem\CoreBundle\Entity\Imobiliario\BaixaConstrucao $fkImobiliarioBaixaConstrucao)
    {
        $this->fkImobiliarioBaixaConstrucoes->removeElement($fkImobiliarioBaixaConstrucao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioBaixaConstrucoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaConstrucao
     */
    public function getFkImobiliarioBaixaConstrucoes()
    {
        return $this->fkImobiliarioBaixaConstrucoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioConstrucaoReforma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReforma $fkImobiliarioConstrucaoReforma
     * @return Construcao
     */
    public function addFkImobiliarioConstrucaoReformas(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReforma $fkImobiliarioConstrucaoReforma)
    {
        if (false === $this->fkImobiliarioConstrucaoReformas->contains($fkImobiliarioConstrucaoReforma)) {
            $fkImobiliarioConstrucaoReforma->setFkImobiliarioConstrucao($this);
            $this->fkImobiliarioConstrucaoReformas->add($fkImobiliarioConstrucaoReforma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioConstrucaoReforma
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReforma $fkImobiliarioConstrucaoReforma
     */
    public function removeFkImobiliarioConstrucaoReformas(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReforma $fkImobiliarioConstrucaoReforma)
    {
        $this->fkImobiliarioConstrucaoReformas->removeElement($fkImobiliarioConstrucaoReforma);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioConstrucaoReformas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoReforma
     */
    public function getFkImobiliarioConstrucaoReformas()
    {
        return $this->fkImobiliarioConstrucaoReformas;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioConstrucaoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso $fkImobiliarioConstrucaoProcesso
     * @return Construcao
     */
    public function addFkImobiliarioConstrucaoProcessos(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso $fkImobiliarioConstrucaoProcesso)
    {
        if (false === $this->fkImobiliarioConstrucaoProcessos->contains($fkImobiliarioConstrucaoProcesso)) {
            $fkImobiliarioConstrucaoProcesso->setFkImobiliarioConstrucao($this);
            $this->fkImobiliarioConstrucaoProcessos->add($fkImobiliarioConstrucaoProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioConstrucaoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso $fkImobiliarioConstrucaoProcesso
     */
    public function removeFkImobiliarioConstrucaoProcessos(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso $fkImobiliarioConstrucaoProcesso)
    {
        $this->fkImobiliarioConstrucaoProcessos->removeElement($fkImobiliarioConstrucaoProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioConstrucaoProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso
     */
    public function getFkImobiliarioConstrucaoProcessos()
    {
        return $this->fkImobiliarioConstrucaoProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaImovelNovaConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaConstrucao $fkImobiliarioLicencaImovelNovaConstrucao
     * @return Construcao
     */
    public function addFkImobiliarioLicencaImovelNovaConstrucoes(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaConstrucao $fkImobiliarioLicencaImovelNovaConstrucao)
    {
        if (false === $this->fkImobiliarioLicencaImovelNovaConstrucoes->contains($fkImobiliarioLicencaImovelNovaConstrucao)) {
            $fkImobiliarioLicencaImovelNovaConstrucao->setFkImobiliarioConstrucao($this);
            $this->fkImobiliarioLicencaImovelNovaConstrucoes->add($fkImobiliarioLicencaImovelNovaConstrucao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaImovelNovaConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaConstrucao $fkImobiliarioLicencaImovelNovaConstrucao
     */
    public function removeFkImobiliarioLicencaImovelNovaConstrucoes(\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaConstrucao $fkImobiliarioLicencaImovelNovaConstrucao)
    {
        $this->fkImobiliarioLicencaImovelNovaConstrucoes->removeElement($fkImobiliarioLicencaImovelNovaConstrucao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaImovelNovaConstrucoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaConstrucao
     */
    public function getFkImobiliarioLicencaImovelNovaConstrucoes()
    {
        return $this->fkImobiliarioLicencaImovelNovaConstrucoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioUnidadeDependente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente $fkImobiliarioUnidadeDependente
     * @return Construcao
     */
    public function addFkImobiliarioUnidadeDependentes(\Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente $fkImobiliarioUnidadeDependente)
    {
        if (false === $this->fkImobiliarioUnidadeDependentes->contains($fkImobiliarioUnidadeDependente)) {
            $fkImobiliarioUnidadeDependente->setFkImobiliarioConstrucao($this);
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
     * OneToMany (owning side)
     * Add ImobiliarioConstrucaoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao
     * @return Construcao
     */
    public function addFkImobiliarioConstrucaoEdificacoes(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao)
    {
        if (false === $this->fkImobiliarioConstrucaoEdificacoes->contains($fkImobiliarioConstrucaoEdificacao)) {
            $fkImobiliarioConstrucaoEdificacao->setFkImobiliarioConstrucao($this);
            $this->fkImobiliarioConstrucaoEdificacoes->add($fkImobiliarioConstrucaoEdificacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioConstrucaoEdificacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao
     */
    public function removeFkImobiliarioConstrucaoEdificacoes(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao $fkImobiliarioConstrucaoEdificacao)
    {
        $this->fkImobiliarioConstrucaoEdificacoes->removeElement($fkImobiliarioConstrucaoEdificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioConstrucaoEdificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao
     */
    public function getFkImobiliarioConstrucaoEdificacoes()
    {
        return $this->fkImobiliarioConstrucaoEdificacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioConstrucaoCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoCondominio $fkImobiliarioConstrucaoCondominio
     * @return Construcao
     */
    public function addFkImobiliarioConstrucaoCondominios(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoCondominio $fkImobiliarioConstrucaoCondominio)
    {
        if (false === $this->fkImobiliarioConstrucaoCondominios->contains($fkImobiliarioConstrucaoCondominio)) {
            $fkImobiliarioConstrucaoCondominio->setFkImobiliarioConstrucao($this);
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
     * OneToOne (inverse side)
     * Set ImobiliarioConstrucaoOutros
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoOutros $fkImobiliarioConstrucaoOutros
     * @return Construcao
     */
    public function setFkImobiliarioConstrucaoOutros(\Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoOutros $fkImobiliarioConstrucaoOutros)
    {
        $fkImobiliarioConstrucaoOutros->setFkImobiliarioConstrucao($this);
        $this->fkImobiliarioConstrucaoOutros = $fkImobiliarioConstrucaoOutros;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioConstrucaoOutros
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoOutros
     */
    public function getFkImobiliarioConstrucaoOutros()
    {
        return $this->fkImobiliarioConstrucaoOutros;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioDataConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\DataConstrucao $fkImobiliarioDataConstrucao
     * @return Construcao
     */
    public function setFkImobiliarioDataConstrucao(\Urbem\CoreBundle\Entity\Imobiliario\DataConstrucao $fkImobiliarioDataConstrucao)
    {
        $fkImobiliarioDataConstrucao->setFkImobiliarioConstrucao($this);
        $this->fkImobiliarioDataConstrucao = $fkImobiliarioDataConstrucao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioDataConstrucao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\DataConstrucao
     */
    public function getFkImobiliarioDataConstrucao()
    {
        return $this->fkImobiliarioDataConstrucao;
    }

    /**
     * @return string
     */
    public function getArea()
    {
        return ($this->getFkImobiliarioUnidadeDependentes()->count())
            ? number_format($this->getFkImobiliarioUnidadeDependentes()->last()->getFkImobiliarioAreaUnidadeDependentes()->last()->getArea(), 2, ',', '.')
            : number_format($this->getFkImobiliarioAreaConstrucoes()->last()->getAreaReal(), 2, ',', '.');
    }

    /**
     * @return null|string
     */
    public function getTipoEdificacao()
    {
        return ($this->getFkImobiliarioConstrucaoEdificacoes()->count())
            ? $this->getFkImobiliarioConstrucaoEdificacoes()->last()->getFkImobiliarioTipoEdificacao()
            : null;
    }

    /**
     * @return null|Imovel
     */
    public function getImovel()
    {
        if ($this->fkImobiliarioUnidadeDependentes->count()) {
            return $this->fkImobiliarioUnidadeDependentes->current()->getFkImobiliarioUnidadeAutonoma()->getFkImobiliarioImovel();
        } elseif ($this->fkImobiliarioConstrucaoEdificacoes->count()) {
            return ($this->fkImobiliarioConstrucaoEdificacoes->current()->getFkImobiliarioUnidadeAutonomas()->count())
                ? $this->fkImobiliarioConstrucaoEdificacoes->current()->getFkImobiliarioUnidadeAutonomas()->current()->getFkImobiliarioImovel()
                : null;
        } else {
            return null;
        }
    }

    /**
     * @return null|string
     */
    public function getLote()
    {
        return ($this->getImovel())
            ? $this->getImovel()->getLote()
            : null;
    }

    /**
     * @return null|string
     */
    public function getLocalizacao()
    {
        return ($this->getImovel())
            ? $this->getImovel()->getLocalizacao()
            : null;
    }

    /**
     * @return null|string
     */
    public function getCondominio()
    {
        return ($this->fkImobiliarioConstrucaoCondominios->count())
            ? $this->fkImobiliarioConstrucaoCondominios->last()->getFkImobiliarioCondominio()
            : null;
    }

    /**
     * @return null|string
     */
    public function getDescricao()
    {
        return ($this->fkImobiliarioConstrucaoOutros)
            ? $this->getFkImobiliarioConstrucaoOutros()->getDescricao()
            : null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codConstrucao;
    }
}
