<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * Objeto
 */
class Objeto
{
    /**
     * PK
     * @var integer
     */
    private $codObjeto;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    private $fkComprasCompraDiretas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    private $fkComprasSolicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    private $fkLicitacaoConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Convenio
     */
    private $fkTcemgConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\Convenio
     */
    private $fkTcernConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Mapa
     */
    private $fkComprasMapas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ContratoAditivo
     */
    private $fkTcernContratoAditivos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasCompraDiretas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasMapas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernContratoAditivos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codObjeto
     *
     * @param integer $codObjeto
     * @return Objeto
     */
    public function setCodObjeto($codObjeto)
    {
        $this->codObjeto = $codObjeto;
        return $this;
    }

    /**
     * Get codObjeto
     *
     * @return integer
     */
    public function getCodObjeto()
    {
        return $this->codObjeto;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Objeto
     */
    public function setDescricao($descricao = null)
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
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return Objeto
     */
    public function setTimestamp(\DateTime $timestamp = null)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     * @return Objeto
     */
    public function addFkComprasCompraDiretas(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        if (false === $this->fkComprasCompraDiretas->contains($fkComprasCompraDireta)) {
            $fkComprasCompraDireta->setFkComprasObjeto($this);
            $this->fkComprasCompraDiretas->add($fkComprasCompraDireta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     */
    public function removeFkComprasCompraDiretas(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        $this->fkComprasCompraDiretas->removeElement($fkComprasCompraDireta);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasCompraDiretas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    public function getFkComprasCompraDiretas()
    {
        return $this->fkComprasCompraDiretas;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     * @return Objeto
     */
    public function addFkComprasSolicitacoes(\Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao)
    {
        if (false === $this->fkComprasSolicitacoes->contains($fkComprasSolicitacao)) {
            $fkComprasSolicitacao->setFkComprasObjeto($this);
            $this->fkComprasSolicitacoes->add($fkComprasSolicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     */
    public function removeFkComprasSolicitacoes(\Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao)
    {
        $this->fkComprasSolicitacoes->removeElement($fkComprasSolicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    public function getFkComprasSolicitacoes()
    {
        return $this->fkComprasSolicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     * @return Objeto
     */
    public function addFkLicitacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        if (false === $this->fkLicitacaoConvenios->contains($fkLicitacaoConvenio)) {
            $fkLicitacaoConvenio->setFkComprasObjeto($this);
            $this->fkLicitacaoConvenios->add($fkLicitacaoConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     */
    public function removeFkLicitacaoConvenios(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        $this->fkLicitacaoConvenios->removeElement($fkLicitacaoConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    public function getFkLicitacaoConvenios()
    {
        return $this->fkLicitacaoConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return Objeto
     */
    public function addFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        if (false === $this->fkLicitacaoLicitacoes->contains($fkLicitacaoLicitacao)) {
            $fkLicitacaoLicitacao->setFkComprasObjeto($this);
            $this->fkLicitacaoLicitacoes->add($fkLicitacaoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     */
    public function removeFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->fkLicitacaoLicitacoes->removeElement($fkLicitacaoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacoes()
    {
        return $this->fkLicitacaoLicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Convenio $fkTcemgConvenio
     * @return Objeto
     */
    public function addFkTcemgConvenios(\Urbem\CoreBundle\Entity\Tcemg\Convenio $fkTcemgConvenio)
    {
        if (false === $this->fkTcemgConvenios->contains($fkTcemgConvenio)) {
            $fkTcemgConvenio->setFkComprasObjeto($this);
            $this->fkTcemgConvenios->add($fkTcemgConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Convenio $fkTcemgConvenio
     */
    public function removeFkTcemgConvenios(\Urbem\CoreBundle\Entity\Tcemg\Convenio $fkTcemgConvenio)
    {
        $this->fkTcemgConvenios->removeElement($fkTcemgConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\Convenio
     */
    public function getFkTcemgConvenios()
    {
        return $this->fkTcemgConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add TcernConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Convenio $fkTcernConvenio
     * @return Objeto
     */
    public function addFkTcernConvenios(\Urbem\CoreBundle\Entity\Tcern\Convenio $fkTcernConvenio)
    {
        if (false === $this->fkTcernConvenios->contains($fkTcernConvenio)) {
            $fkTcernConvenio->setFkComprasObjeto($this);
            $this->fkTcernConvenios->add($fkTcernConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Convenio $fkTcernConvenio
     */
    public function removeFkTcernConvenios(\Urbem\CoreBundle\Entity\Tcern\Convenio $fkTcernConvenio)
    {
        $this->fkTcernConvenios->removeElement($fkTcernConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\Convenio
     */
    public function getFkTcernConvenios()
    {
        return $this->fkTcernConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapa
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa
     * @return Objeto
     */
    public function addFkComprasMapas(\Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa)
    {
        if (false === $this->fkComprasMapas->contains($fkComprasMapa)) {
            $fkComprasMapa->setFkComprasObjeto($this);
            $this->fkComprasMapas->add($fkComprasMapa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapa
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa
     */
    public function removeFkComprasMapas(\Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa)
    {
        $this->fkComprasMapas->removeElement($fkComprasMapa);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Mapa
     */
    public function getFkComprasMapas()
    {
        return $this->fkComprasMapas;
    }

    /**
     * OneToMany (owning side)
     * Add TcernContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ContratoAditivo $fkTcernContratoAditivo
     * @return Objeto
     */
    public function addFkTcernContratoAditivos(\Urbem\CoreBundle\Entity\Tcern\ContratoAditivo $fkTcernContratoAditivo)
    {
        if (false === $this->fkTcernContratoAditivos->contains($fkTcernContratoAditivo)) {
            $fkTcernContratoAditivo->setFkComprasObjeto($this);
            $this->fkTcernContratoAditivos->add($fkTcernContratoAditivo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ContratoAditivo $fkTcernContratoAditivo
     */
    public function removeFkTcernContratoAditivos(\Urbem\CoreBundle\Entity\Tcern\ContratoAditivo $fkTcernContratoAditivo)
    {
        $this->fkTcernContratoAditivos->removeElement($fkTcernContratoAditivo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernContratoAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ContratoAditivo
     */
    public function getFkTcernContratoAditivos()
    {
        return $this->fkTcernContratoAditivos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codObjeto, $this->descricao);
    }
}
