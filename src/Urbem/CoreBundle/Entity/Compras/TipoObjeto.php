<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * TipoObjeto
 */
class TipoObjeto
{
    /**
     * PK
     * @var integer
     */
    private $codTipoObjeto;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    private $fkComprasCompraDiretas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasCompraDiretas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoObjeto
     *
     * @param integer $codTipoObjeto
     * @return TipoObjeto
     */
    public function setCodTipoObjeto($codTipoObjeto)
    {
        $this->codTipoObjeto = $codTipoObjeto;
        return $this;
    }

    /**
     * Get codTipoObjeto
     *
     * @return integer
     */
    public function getCodTipoObjeto()
    {
        return $this->codTipoObjeto;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoObjeto
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
     * OneToMany (owning side)
     * Add ComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     * @return TipoObjeto
     */
    public function addFkComprasCompraDiretas(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        if (false === $this->fkComprasCompraDiretas->contains($fkComprasCompraDireta)) {
            $fkComprasCompraDireta->setFkComprasTipoObjeto($this);
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
     * Add LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return TipoObjeto
     */
    public function addFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        if (false === $this->fkLicitacaoContratos->contains($fkLicitacaoContrato)) {
            $fkLicitacaoContrato->setFkComprasTipoObjeto($this);
            $this->fkLicitacaoContratos->add($fkLicitacaoContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     */
    public function removeFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->fkLicitacaoContratos->removeElement($fkLicitacaoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContratos()
    {
        return $this->fkLicitacaoContratos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return TipoObjeto
     */
    public function addFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        if (false === $this->fkLicitacaoLicitacoes->contains($fkLicitacaoLicitacao)) {
            $fkLicitacaoLicitacao->setFkComprasTipoObjeto($this);
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
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codTipoObjeto, $this->descricao);
    }
}
