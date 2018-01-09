<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * VeiculosPublicidade
 */
class VeiculosPublicidade
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codTipoVeiculosPublicidade;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta
     */
    private $fkComprasPublicacaoCompraDiretas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ldo\Homologacao
     */
    private $fkLdoHomologacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContratoAditivos
     */
    private $fkLicitacaoPublicacaoContratoAditivos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoContrato
     */
    private $fkLicitacaoPublicacaoRescisaoContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoConvenio
     */
    private $fkLicitacaoPublicacaoConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital
     */
    private $fkLicitacaoPublicacaoEditais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao
     */
    private $fkPpaPpaPublicacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\PublicacaoRreo
     */
    private $fkTcealPublicacaoRreos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\PublicacaoRgf
     */
    private $fkTcealPublicacaoRgfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    private $fkTcemgContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato
     */
    private $fkLicitacaoPublicacaoContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoAta
     */
    private $fkLicitacaoPublicacaoAtas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo
     */
    private $fkTcemgContratoAditivos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoVeiculosPublicidade
     */
    private $fkLicitacaoTipoVeiculosPublicidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasPublicacaoCompraDiretas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLdoHomologacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoPublicacaoContratoAditivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoPublicacaoRescisaoContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoPublicacaoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoPublicacaoEditais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPpaPpaPublicacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcealPublicacaoRreos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcealPublicacaoRgfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoPublicacaoContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoPublicacaoAtas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratoAditivos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return VeiculosPublicidade
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codTipoVeiculosPublicidade
     *
     * @param integer $codTipoVeiculosPublicidade
     * @return VeiculosPublicidade
     */
    public function setCodTipoVeiculosPublicidade($codTipoVeiculosPublicidade)
    {
        $this->codTipoVeiculosPublicidade = $codTipoVeiculosPublicidade;
        return $this;
    }

    /**
     * Get codTipoVeiculosPublicidade
     *
     * @return integer
     */
    public function getCodTipoVeiculosPublicidade()
    {
        return $this->codTipoVeiculosPublicidade;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasPublicacaoCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta $fkComprasPublicacaoCompraDireta
     * @return VeiculosPublicidade
     */
    public function addFkComprasPublicacaoCompraDiretas(\Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta $fkComprasPublicacaoCompraDireta)
    {
        if (false === $this->fkComprasPublicacaoCompraDiretas->contains($fkComprasPublicacaoCompraDireta)) {
            $fkComprasPublicacaoCompraDireta->setFkLicitacaoVeiculosPublicidade($this);
            $this->fkComprasPublicacaoCompraDiretas->add($fkComprasPublicacaoCompraDireta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasPublicacaoCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta $fkComprasPublicacaoCompraDireta
     */
    public function removeFkComprasPublicacaoCompraDiretas(\Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta $fkComprasPublicacaoCompraDireta)
    {
        $this->fkComprasPublicacaoCompraDiretas->removeElement($fkComprasPublicacaoCompraDireta);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasPublicacaoCompraDiretas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\PublicacaoCompraDireta
     */
    public function getFkComprasPublicacaoCompraDiretas()
    {
        return $this->fkComprasPublicacaoCompraDiretas;
    }

    /**
     * OneToMany (owning side)
     * Add LdoHomologacao
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao
     * @return VeiculosPublicidade
     */
    public function addFkLdoHomologacoes(\Urbem\CoreBundle\Entity\Ldo\Homologacao $fkLdoHomologacao)
    {
        if (false === $this->fkLdoHomologacoes->contains($fkLdoHomologacao)) {
            $fkLdoHomologacao->setFkLicitacaoVeiculosPublicidade($this);
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
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoContratoAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoContratoAditivos $fkLicitacaoPublicacaoContratoAditivos
     * @return VeiculosPublicidade
     */
    public function addFkLicitacaoPublicacaoContratoAditivos(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContratoAditivos $fkLicitacaoPublicacaoContratoAditivos)
    {
        if (false === $this->fkLicitacaoPublicacaoContratoAditivos->contains($fkLicitacaoPublicacaoContratoAditivos)) {
            $fkLicitacaoPublicacaoContratoAditivos->setFkLicitacaoVeiculosPublicidade($this);
            $this->fkLicitacaoPublicacaoContratoAditivos->add($fkLicitacaoPublicacaoContratoAditivos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoContratoAditivos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoContratoAditivos $fkLicitacaoPublicacaoContratoAditivos
     */
    public function removeFkLicitacaoPublicacaoContratoAditivos(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContratoAditivos $fkLicitacaoPublicacaoContratoAditivos)
    {
        $this->fkLicitacaoPublicacaoContratoAditivos->removeElement($fkLicitacaoPublicacaoContratoAditivos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoContratoAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContratoAditivos
     */
    public function getFkLicitacaoPublicacaoContratoAditivos()
    {
        return $this->fkLicitacaoPublicacaoContratoAditivos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoRescisaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoContrato $fkLicitacaoPublicacaoRescisaoContrato
     * @return VeiculosPublicidade
     */
    public function addFkLicitacaoPublicacaoRescisaoContratos(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoContrato $fkLicitacaoPublicacaoRescisaoContrato)
    {
        if (false === $this->fkLicitacaoPublicacaoRescisaoContratos->contains($fkLicitacaoPublicacaoRescisaoContrato)) {
            $fkLicitacaoPublicacaoRescisaoContrato->setFkLicitacaoVeiculosPublicidade($this);
            $this->fkLicitacaoPublicacaoRescisaoContratos->add($fkLicitacaoPublicacaoRescisaoContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoRescisaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoContrato $fkLicitacaoPublicacaoRescisaoContrato
     */
    public function removeFkLicitacaoPublicacaoRescisaoContratos(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoContrato $fkLicitacaoPublicacaoRescisaoContrato)
    {
        $this->fkLicitacaoPublicacaoRescisaoContratos->removeElement($fkLicitacaoPublicacaoRescisaoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoRescisaoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoRescisaoContrato
     */
    public function getFkLicitacaoPublicacaoRescisaoContratos()
    {
        return $this->fkLicitacaoPublicacaoRescisaoContratos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoConvenio $fkLicitacaoPublicacaoConvenio
     * @return VeiculosPublicidade
     */
    public function addFkLicitacaoPublicacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoConvenio $fkLicitacaoPublicacaoConvenio)
    {
        if (false === $this->fkLicitacaoPublicacaoConvenios->contains($fkLicitacaoPublicacaoConvenio)) {
            $fkLicitacaoPublicacaoConvenio->setFkLicitacaoVeiculosPublicidade($this);
            $this->fkLicitacaoPublicacaoConvenios->add($fkLicitacaoPublicacaoConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoConvenio $fkLicitacaoPublicacaoConvenio
     */
    public function removeFkLicitacaoPublicacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoConvenio $fkLicitacaoPublicacaoConvenio)
    {
        $this->fkLicitacaoPublicacaoConvenios->removeElement($fkLicitacaoPublicacaoConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoConvenio
     */
    public function getFkLicitacaoPublicacaoConvenios()
    {
        return $this->fkLicitacaoPublicacaoConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital $fkLicitacaoPublicacaoEdital
     * @return VeiculosPublicidade
     */
    public function addFkLicitacaoPublicacaoEditais(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital $fkLicitacaoPublicacaoEdital)
    {
        if (false === $this->fkLicitacaoPublicacaoEditais->contains($fkLicitacaoPublicacaoEdital)) {
            $fkLicitacaoPublicacaoEdital->setFkLicitacaoVeiculosPublicidade($this);
            $this->fkLicitacaoPublicacaoEditais->add($fkLicitacaoPublicacaoEdital);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital $fkLicitacaoPublicacaoEdital
     */
    public function removeFkLicitacaoPublicacaoEditais(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital $fkLicitacaoPublicacaoEdital)
    {
        $this->fkLicitacaoPublicacaoEditais->removeElement($fkLicitacaoPublicacaoEdital);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoEditais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoEdital
     */
    public function getFkLicitacaoPublicacaoEditais()
    {
        return $this->fkLicitacaoPublicacaoEditais;
    }

    /**
     * OneToMany (owning side)
     * Add PpaPpaPublicacao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao
     * @return VeiculosPublicidade
     */
    public function addFkPpaPpaPublicacoes(\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao)
    {
        if (false === $this->fkPpaPpaPublicacoes->contains($fkPpaPpaPublicacao)) {
            $fkPpaPpaPublicacao->setFkLicitacaoVeiculosPublicidade($this);
            $this->fkPpaPpaPublicacoes->add($fkPpaPpaPublicacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaPpaPublicacao
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao
     */
    public function removeFkPpaPpaPublicacoes(\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao $fkPpaPpaPublicacao)
    {
        $this->fkPpaPpaPublicacoes->removeElement($fkPpaPpaPublicacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaPpaPublicacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\PpaPublicacao
     */
    public function getFkPpaPpaPublicacoes()
    {
        return $this->fkPpaPpaPublicacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcealPublicacaoRreo
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\PublicacaoRreo $fkTcealPublicacaoRreo
     * @return VeiculosPublicidade
     */
    public function addFkTcealPublicacaoRreos(\Urbem\CoreBundle\Entity\Tceal\PublicacaoRreo $fkTcealPublicacaoRreo)
    {
        if (false === $this->fkTcealPublicacaoRreos->contains($fkTcealPublicacaoRreo)) {
            $fkTcealPublicacaoRreo->setFkLicitacaoVeiculosPublicidade($this);
            $this->fkTcealPublicacaoRreos->add($fkTcealPublicacaoRreo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealPublicacaoRreo
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\PublicacaoRreo $fkTcealPublicacaoRreo
     */
    public function removeFkTcealPublicacaoRreos(\Urbem\CoreBundle\Entity\Tceal\PublicacaoRreo $fkTcealPublicacaoRreo)
    {
        $this->fkTcealPublicacaoRreos->removeElement($fkTcealPublicacaoRreo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealPublicacaoRreos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\PublicacaoRreo
     */
    public function getFkTcealPublicacaoRreos()
    {
        return $this->fkTcealPublicacaoRreos;
    }

    /**
     * OneToMany (owning side)
     * Add TcealPublicacaoRgf
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\PublicacaoRgf $fkTcealPublicacaoRgf
     * @return VeiculosPublicidade
     */
    public function addFkTcealPublicacaoRgfs(\Urbem\CoreBundle\Entity\Tceal\PublicacaoRgf $fkTcealPublicacaoRgf)
    {
        if (false === $this->fkTcealPublicacaoRgfs->contains($fkTcealPublicacaoRgf)) {
            $fkTcealPublicacaoRgf->setFkLicitacaoVeiculosPublicidade($this);
            $this->fkTcealPublicacaoRgfs->add($fkTcealPublicacaoRgf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcealPublicacaoRgf
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\PublicacaoRgf $fkTcealPublicacaoRgf
     */
    public function removeFkTcealPublicacaoRgfs(\Urbem\CoreBundle\Entity\Tceal\PublicacaoRgf $fkTcealPublicacaoRgf)
    {
        $this->fkTcealPublicacaoRgfs->removeElement($fkTcealPublicacaoRgf);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcealPublicacaoRgfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceal\PublicacaoRgf
     */
    public function getFkTcealPublicacaoRgfs()
    {
        return $this->fkTcealPublicacaoRgfs;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     * @return VeiculosPublicidade
     */
    public function addFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        if (false === $this->fkTcemgContratos->contains($fkTcemgContrato)) {
            $fkTcemgContrato->setFkLicitacaoVeiculosPublicidade($this);
            $this->fkTcemgContratos->add($fkTcemgContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato
     */
    public function removeFkTcemgContratos(\Urbem\CoreBundle\Entity\Tcemg\Contrato $fkTcemgContrato)
    {
        $this->fkTcemgContratos->removeElement($fkTcemgContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Contrato
     */
    public function getFkTcemgContratos()
    {
        return $this->fkTcemgContratos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato $fkLicitacaoPublicacaoContrato
     * @return VeiculosPublicidade
     */
    public function addFkLicitacaoPublicacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato $fkLicitacaoPublicacaoContrato)
    {
        if (false === $this->fkLicitacaoPublicacaoContratos->contains($fkLicitacaoPublicacaoContrato)) {
            $fkLicitacaoPublicacaoContrato->setFkLicitacaoVeiculosPublicidade($this);
            $this->fkLicitacaoPublicacaoContratos->add($fkLicitacaoPublicacaoContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato $fkLicitacaoPublicacaoContrato
     */
    public function removeFkLicitacaoPublicacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato $fkLicitacaoPublicacaoContrato)
    {
        $this->fkLicitacaoPublicacaoContratos->removeElement($fkLicitacaoPublicacaoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoContrato
     */
    public function getFkLicitacaoPublicacaoContratos()
    {
        return $this->fkLicitacaoPublicacaoContratos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoPublicacaoAta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoAta $fkLicitacaoPublicacaoAta
     * @return VeiculosPublicidade
     */
    public function addFkLicitacaoPublicacaoAtas(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoAta $fkLicitacaoPublicacaoAta)
    {
        if (false === $this->fkLicitacaoPublicacaoAtas->contains($fkLicitacaoPublicacaoAta)) {
            $fkLicitacaoPublicacaoAta->setFkLicitacaoVeiculosPublicidade($this);
            $this->fkLicitacaoPublicacaoAtas->add($fkLicitacaoPublicacaoAta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoPublicacaoAta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\PublicacaoAta $fkLicitacaoPublicacaoAta
     */
    public function removeFkLicitacaoPublicacaoAtas(\Urbem\CoreBundle\Entity\Licitacao\PublicacaoAta $fkLicitacaoPublicacaoAta)
    {
        $this->fkLicitacaoPublicacaoAtas->removeElement($fkLicitacaoPublicacaoAta);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoPublicacaoAtas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\PublicacaoAta
     */
    public function getFkLicitacaoPublicacaoAtas()
    {
        return $this->fkLicitacaoPublicacaoAtas;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo
     * @return VeiculosPublicidade
     */
    public function addFkTcemgContratoAditivos(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo)
    {
        if (false === $this->fkTcemgContratoAditivos->contains($fkTcemgContratoAditivo)) {
            $fkTcemgContratoAditivo->setFkLicitacaoVeiculosPublicidade($this);
            $this->fkTcemgContratoAditivos->add($fkTcemgContratoAditivo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo
     */
    public function removeFkTcemgContratoAditivos(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo $fkTcemgContratoAditivo)
    {
        $this->fkTcemgContratoAditivos->removeElement($fkTcemgContratoAditivo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo
     */
    public function getFkTcemgContratoAditivos()
    {
        return $this->fkTcemgContratoAditivos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoTipoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoVeiculosPublicidade $fkLicitacaoTipoVeiculosPublicidade
     * @return VeiculosPublicidade
     */
    public function setFkLicitacaoTipoVeiculosPublicidade(\Urbem\CoreBundle\Entity\Licitacao\TipoVeiculosPublicidade $fkLicitacaoTipoVeiculosPublicidade)
    {
        $this->codTipoVeiculosPublicidade = $fkLicitacaoTipoVeiculosPublicidade->getCodTipoVeiculosPublicidade();
        $this->fkLicitacaoTipoVeiculosPublicidade = $fkLicitacaoTipoVeiculosPublicidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoVeiculosPublicidade
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoVeiculosPublicidade
     */
    public function getFkLicitacaoTipoVeiculosPublicidade()
    {
        return $this->fkLicitacaoTipoVeiculosPublicidade;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return VeiculosPublicidade
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s | %s', $this->fkLicitacaoTipoVeiculosPublicidade, $this->fkSwCgm);
    }
}
