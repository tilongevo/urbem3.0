<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * TipoLicitacao
 */
class TipoLicitacao
{
    const ITEM = 1;
    const LOTE = 2;
    const PRECO_GLOBAL = 3;

    /**
     * PK
     * @var integer
     */
    private $codTipoLicitacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\Mapa
     */
    private $fkComprasMapas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasMapas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoLicitacao
     *
     * @param integer $codTipoLicitacao
     * @return TipoLicitacao
     */
    public function setCodTipoLicitacao($codTipoLicitacao)
    {
        $this->codTipoLicitacao = $codTipoLicitacao;
        return $this;
    }

    /**
     * Get codTipoLicitacao
     *
     * @return integer
     */
    public function getCodTipoLicitacao()
    {
        return $this->codTipoLicitacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoLicitacao
     */
    public function setDescricao($descricao)
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
     * Add LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return TipoLicitacao
     */
    public function addFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        if (false === $this->fkLicitacaoLicitacoes->contains($fkLicitacaoLicitacao)) {
            $fkLicitacaoLicitacao->setFkComprasTipoLicitacao($this);
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
     * Add ComprasMapa
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa
     * @return TipoLicitacao
     */
    public function addFkComprasMapas(\Urbem\CoreBundle\Entity\Compras\Mapa $fkComprasMapa)
    {
        if (false === $this->fkComprasMapas->contains($fkComprasMapa)) {
            $fkComprasMapa->setFkComprasTipoLicitacao($this);
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

    public function __toString()
    {
        return sprintf('%s - %s', $this->codTipoLicitacao, $this->descricao);
    }
}
