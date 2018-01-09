<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * UnidadeMedida
 */
class UnidadeMedida
{
    /**
     * PK
     * @var integer
     */
    private $codUnidade;

    /**
     * PK
     * @var integer
     */
    private $codGrandeza;

    /**
     * @var string
     */
    private $nomUnidade;

    /**
     * @var string
     */
    private $simbolo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    private $fkEmpenhoItemPreEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AreaLote
     */
    private $fkImobiliarioAreaLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\TipoIndicadores
     */
    private $fkLdoTipoIndicadoreses;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    private $fkPpaAcaoDados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Obra
     */
    private $fkTcmgoObras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta
     */
    private $fkFiscalizacaoPenalidadeMultas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores
     */
    private $fkPpaProgramaIndicadoreses;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwItemPreEmpenho
     */
    private $fkSwItemPreEmpenhos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Grandeza
     */
    private $fkAdministracaoGrandeza;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoCatalogoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoItemPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioAreaLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLdoTipoIndicadoreses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaAcaoDados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmgoObras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoPenalidadeMultas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaProgramaIndicadoreses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwItemPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return UnidadeMedida
     */
    public function setCodUnidade($codUnidade)
    {
        $this->codUnidade = $codUnidade;
        return $this;
    }

    /**
     * Get codUnidade
     *
     * @return integer
     */
    public function getCodUnidade()
    {
        return $this->codUnidade;
    }

    /**
     * Set codGrandeza
     *
     * @param integer $codGrandeza
     * @return UnidadeMedida
     */
    public function setCodGrandeza($codGrandeza)
    {
        $this->codGrandeza = $codGrandeza;
        return $this;
    }

    /**
     * Get codGrandeza
     *
     * @return integer
     */
    public function getCodGrandeza()
    {
        return $this->codGrandeza;
    }

    /**
     * Set nomUnidade
     *
     * @param string $nomUnidade
     * @return UnidadeMedida
     */
    public function setNomUnidade($nomUnidade)
    {
        $this->nomUnidade = $nomUnidade;
        return $this;
    }

    /**
     * Get nomUnidade
     *
     * @return string
     */
    public function getNomUnidade()
    {
        return $this->nomUnidade;
    }

    /**
     * Set simbolo
     *
     * @param string $simbolo
     * @return UnidadeMedida
     */
    public function setSimbolo($simbolo)
    {
        $this->simbolo = $simbolo;
        return $this;
    }

    /**
     * Get simbolo
     *
     * @return string
     */
    public function getSimbolo()
    {
        return $this->simbolo;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return UnidadeMedida
     */
    public function addFkAlmoxarifadoCatalogoItens(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        if (false === $this->fkAlmoxarifadoCatalogoItens->contains($fkAlmoxarifadoCatalogoItem)) {
            $fkAlmoxarifadoCatalogoItem->setFkAdministracaoUnidadeMedida($this);
            $this->fkAlmoxarifadoCatalogoItens->add($fkAlmoxarifadoCatalogoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     */
    public function removeFkAlmoxarifadoCatalogoItens(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        $this->fkAlmoxarifadoCatalogoItens->removeElement($fkAlmoxarifadoCatalogoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCatalogoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    public function getFkAlmoxarifadoCatalogoItens()
    {
        return $this->fkAlmoxarifadoCatalogoItens;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     * @return UnidadeMedida
     */
    public function addFkEmpenhoItemPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        if (false === $this->fkEmpenhoItemPreEmpenhos->contains($fkEmpenhoItemPreEmpenho)) {
            $fkEmpenhoItemPreEmpenho->setFkAdministracaoUnidadeMedida($this);
            $this->fkEmpenhoItemPreEmpenhos->add($fkEmpenhoItemPreEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     */
    public function removeFkEmpenhoItemPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        $this->fkEmpenhoItemPreEmpenhos->removeElement($fkEmpenhoItemPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoItemPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    public function getFkEmpenhoItemPreEmpenhos()
    {
        return $this->fkEmpenhoItemPreEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAreaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AreaLote $fkImobiliarioAreaLote
     * @return UnidadeMedida
     */
    public function addFkImobiliarioAreaLotes(\Urbem\CoreBundle\Entity\Imobiliario\AreaLote $fkImobiliarioAreaLote)
    {
        if (false === $this->fkImobiliarioAreaLotes->contains($fkImobiliarioAreaLote)) {
            $fkImobiliarioAreaLote->setFkAdministracaoUnidadeMedida($this);
            $this->fkImobiliarioAreaLotes->add($fkImobiliarioAreaLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAreaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AreaLote $fkImobiliarioAreaLote
     */
    public function removeFkImobiliarioAreaLotes(\Urbem\CoreBundle\Entity\Imobiliario\AreaLote $fkImobiliarioAreaLote)
    {
        $this->fkImobiliarioAreaLotes->removeElement($fkImobiliarioAreaLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAreaLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AreaLote
     */
    public function getFkImobiliarioAreaLotes()
    {
        return $this->fkImobiliarioAreaLotes;
    }

    /**
     * OneToMany (owning side)
     * Add LdoTipoIndicadores
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\TipoIndicadores $fkLdoTipoIndicadores
     * @return UnidadeMedida
     */
    public function addFkLdoTipoIndicadoreses(\Urbem\CoreBundle\Entity\Ldo\TipoIndicadores $fkLdoTipoIndicadores)
    {
        if (false === $this->fkLdoTipoIndicadoreses->contains($fkLdoTipoIndicadores)) {
            $fkLdoTipoIndicadores->setFkAdministracaoUnidadeMedida($this);
            $this->fkLdoTipoIndicadoreses->add($fkLdoTipoIndicadores);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LdoTipoIndicadores
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\TipoIndicadores $fkLdoTipoIndicadores
     */
    public function removeFkLdoTipoIndicadoreses(\Urbem\CoreBundle\Entity\Ldo\TipoIndicadores $fkLdoTipoIndicadores)
    {
        $this->fkLdoTipoIndicadoreses->removeElement($fkLdoTipoIndicadores);
    }

    /**
     * OneToMany (owning side)
     * Get fkLdoTipoIndicadoreses
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\TipoIndicadores
     */
    public function getFkLdoTipoIndicadoreses()
    {
        return $this->fkLdoTipoIndicadoreses;
    }

    /**
     * OneToMany (owning side)
     * Add PpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     * @return UnidadeMedida
     */
    public function addFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        if (false === $this->fkPpaAcaoDados->contains($fkPpaAcaoDados)) {
            $fkPpaAcaoDados->setFkAdministracaoUnidadeMedida($this);
            $this->fkPpaAcaoDados->add($fkPpaAcaoDados);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     */
    public function removeFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        $this->fkPpaAcaoDados->removeElement($fkPpaAcaoDados);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaAcaoDados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    public function getFkPpaAcaoDados()
    {
        return $this->fkPpaAcaoDados;
    }

    /**
     * OneToMany (owning side)
     * Add TcmgoObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Obra $fkTcmgoObra
     * @return UnidadeMedida
     */
    public function addFkTcmgoObras(\Urbem\CoreBundle\Entity\Tcmgo\Obra $fkTcmgoObra)
    {
        if (false === $this->fkTcmgoObras->contains($fkTcmgoObra)) {
            $fkTcmgoObra->setFkAdministracaoUnidadeMedida($this);
            $this->fkTcmgoObras->add($fkTcmgoObra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmgoObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Obra $fkTcmgoObra
     */
    public function removeFkTcmgoObras(\Urbem\CoreBundle\Entity\Tcmgo\Obra $fkTcmgoObra)
    {
        $this->fkTcmgoObras->removeElement($fkTcmgoObra);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmgoObras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmgo\Obra
     */
    public function getFkTcmgoObras()
    {
        return $this->fkTcmgoObras;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoPenalidadeMulta
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta
     * @return UnidadeMedida
     */
    public function addFkFiscalizacaoPenalidadeMultas(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta)
    {
        if (false === $this->fkFiscalizacaoPenalidadeMultas->contains($fkFiscalizacaoPenalidadeMulta)) {
            $fkFiscalizacaoPenalidadeMulta->setFkAdministracaoUnidadeMedida($this);
            $this->fkFiscalizacaoPenalidadeMultas->add($fkFiscalizacaoPenalidadeMulta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoPenalidadeMulta
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta
     */
    public function removeFkFiscalizacaoPenalidadeMultas(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta)
    {
        $this->fkFiscalizacaoPenalidadeMultas->removeElement($fkFiscalizacaoPenalidadeMulta);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoPenalidadeMultas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta
     */
    public function getFkFiscalizacaoPenalidadeMultas()
    {
        return $this->fkFiscalizacaoPenalidadeMultas;
    }

    /**
     * OneToMany (owning side)
     * Add PpaProgramaIndicadores
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores $fkPpaProgramaIndicadores
     * @return UnidadeMedida
     */
    public function addFkPpaProgramaIndicadoreses(\Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores $fkPpaProgramaIndicadores)
    {
        if (false === $this->fkPpaProgramaIndicadoreses->contains($fkPpaProgramaIndicadores)) {
            $fkPpaProgramaIndicadores->setFkAdministracaoUnidadeMedida($this);
            $this->fkPpaProgramaIndicadoreses->add($fkPpaProgramaIndicadores);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaProgramaIndicadores
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores $fkPpaProgramaIndicadores
     */
    public function removeFkPpaProgramaIndicadoreses(\Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores $fkPpaProgramaIndicadores)
    {
        $this->fkPpaProgramaIndicadoreses->removeElement($fkPpaProgramaIndicadores);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaProgramaIndicadoreses
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaIndicadores
     */
    public function getFkPpaProgramaIndicadoreses()
    {
        return $this->fkPpaProgramaIndicadoreses;
    }

    /**
     * OneToMany (owning side)
     * Add SwItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwItemPreEmpenho $fkSwItemPreEmpenho
     * @return UnidadeMedida
     */
    public function addFkSwItemPreEmpenhos(\Urbem\CoreBundle\Entity\SwItemPreEmpenho $fkSwItemPreEmpenho)
    {
        if (false === $this->fkSwItemPreEmpenhos->contains($fkSwItemPreEmpenho)) {
            $fkSwItemPreEmpenho->setFkAdministracaoUnidadeMedida($this);
            $this->fkSwItemPreEmpenhos->add($fkSwItemPreEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwItemPreEmpenho $fkSwItemPreEmpenho
     */
    public function removeFkSwItemPreEmpenhos(\Urbem\CoreBundle\Entity\SwItemPreEmpenho $fkSwItemPreEmpenho)
    {
        $this->fkSwItemPreEmpenhos->removeElement($fkSwItemPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwItemPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwItemPreEmpenho
     */
    public function getFkSwItemPreEmpenhos()
    {
        return $this->fkSwItemPreEmpenhos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoGrandeza
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Grandeza $fkAdministracaoGrandeza
     * @return UnidadeMedida
     */
    public function setFkAdministracaoGrandeza(\Urbem\CoreBundle\Entity\Administracao\Grandeza $fkAdministracaoGrandeza)
    {
        $this->codGrandeza = $fkAdministracaoGrandeza->getCodGrandeza();
        $this->fkAdministracaoGrandeza = $fkAdministracaoGrandeza;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoGrandeza
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Grandeza
     */
    public function getFkAdministracaoGrandeza()
    {
        return $this->fkAdministracaoGrandeza;
    }

    /**
     * @return string
     */
    public function getCodigoComposto()
    {
        return sprintf('%s~%s', $this->codUnidade, $this->codGrandeza);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomUnidade;
    }
}
