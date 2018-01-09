<?php

namespace Urbem\CoreBundle\Entity\Compras;

/**
 * SolicitacaoItem
 */
class SolicitacaoItem
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codSolicitacao;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * @var string
     */
    private $complemento;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $vlTotal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItem
     */
    private $fkComprasMapaItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao
     */
    private $fkComprasSolicitacaoItemAnulacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao
     */
    private $fkComprasSolicitacaoItemDotacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    private $fkComprasSolicitacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto
     */
    private $fkAlmoxarifadoCentroCusto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasMapaItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoItemAnulacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoItemDotacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SolicitacaoItem
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return SolicitacaoItem
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codSolicitacao
     *
     * @param integer $codSolicitacao
     * @return SolicitacaoItem
     */
    public function setCodSolicitacao($codSolicitacao)
    {
        $this->codSolicitacao = $codSolicitacao;
        return $this;
    }

    /**
     * Get codSolicitacao
     *
     * @return integer
     */
    public function getCodSolicitacao()
    {
        return $this->codSolicitacao;
    }

    /**
     * Set codCentro
     *
     * @param integer $codCentro
     * @return SolicitacaoItem
     */
    public function setCodCentro($codCentro)
    {
        $this->codCentro = $codCentro;
        return $this;
    }

    /**
     * Get codCentro
     *
     * @return integer
     */
    public function getCodCentro()
    {
        return $this->codCentro;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return SolicitacaoItem
     */
    public function setCodItem($codItem)
    {
        $this->codItem = $codItem;
        return $this;
    }

    /**
     * Get codItem
     *
     * @return integer
     */
    public function getCodItem()
    {
        return $this->codItem;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     * @return SolicitacaoItem
     */
    public function setComplemento($complemento = null)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return SolicitacaoItem
     */
    public function setQuantidade($quantidade = null)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set vlTotal
     *
     * @param integer $vlTotal
     * @return SolicitacaoItem
     */
    public function setVlTotal($vlTotal = null)
    {
        $this->vlTotal = $vlTotal;
        return $this;
    }

    /**
     * Get vlTotal
     *
     * @return integer
     */
    public function getVlTotal()
    {
        return $this->vlTotal;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapaItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItem $fkComprasMapaItem
     * @return SolicitacaoItem
     */
    public function addFkComprasMapaItens(\Urbem\CoreBundle\Entity\Compras\MapaItem $fkComprasMapaItem)
    {
        if (false === $this->fkComprasMapaItens->contains($fkComprasMapaItem)) {
            $fkComprasMapaItem->setFkComprasSolicitacaoItem($this);
            $this->fkComprasMapaItens->add($fkComprasMapaItem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaItem $fkComprasMapaItem
     */
    public function removeFkComprasMapaItens(\Urbem\CoreBundle\Entity\Compras\MapaItem $fkComprasMapaItem)
    {
        $this->fkComprasMapaItens->removeElement($fkComprasMapaItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaItem
     */
    public function getFkComprasMapaItens()
    {
        return $this->fkComprasMapaItens;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao $fkComprasSolicitacaoItemAnulacao
     * @return SolicitacaoItem
     */
    public function addFkComprasSolicitacaoItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao $fkComprasSolicitacaoItemAnulacao)
    {
        if (false === $this->fkComprasSolicitacaoItemAnulacoes->contains($fkComprasSolicitacaoItemAnulacao)) {
            $fkComprasSolicitacaoItemAnulacao->setFkComprasSolicitacaoItem($this);
            $this->fkComprasSolicitacaoItemAnulacoes->add($fkComprasSolicitacaoItemAnulacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoItemAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao $fkComprasSolicitacaoItemAnulacao
     */
    public function removeFkComprasSolicitacaoItemAnulacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao $fkComprasSolicitacaoItemAnulacao)
    {
        $this->fkComprasSolicitacaoItemAnulacoes->removeElement($fkComprasSolicitacaoItemAnulacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoItemAnulacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao
     */
    public function getFkComprasSolicitacaoItemAnulacoes()
    {
        return $this->fkComprasSolicitacaoItemAnulacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao
     * @return SolicitacaoItem
     */
    public function addFkComprasSolicitacaoItemDotacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao)
    {
        if (false === $this->fkComprasSolicitacaoItemDotacoes->contains($fkComprasSolicitacaoItemDotacao)) {
            $fkComprasSolicitacaoItemDotacao->setFkComprasSolicitacaoItem($this);
            $this->fkComprasSolicitacaoItemDotacoes->add($fkComprasSolicitacaoItemDotacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoItemDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao
     */
    public function removeFkComprasSolicitacaoItemDotacoes(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao $fkComprasSolicitacaoItemDotacao)
    {
        $this->fkComprasSolicitacaoItemDotacoes->removeElement($fkComprasSolicitacaoItemDotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoItemDotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao
     */
    public function getFkComprasSolicitacaoItemDotacoes()
    {
        return $this->fkComprasSolicitacaoItemDotacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasSolicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao
     * @return SolicitacaoItem
     */
    public function setFkComprasSolicitacao(\Urbem\CoreBundle\Entity\Compras\Solicitacao $fkComprasSolicitacao)
    {
        $this->exercicio = $fkComprasSolicitacao->getExercicio();
        $this->codEntidade = $fkComprasSolicitacao->getCodEntidade();
        $this->codSolicitacao = $fkComprasSolicitacao->getCodSolicitacao();
        $this->fkComprasSolicitacao = $fkComprasSolicitacao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasSolicitacao
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Solicitacao
     */
    public function getFkComprasSolicitacao()
    {
        return $this->fkComprasSolicitacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCentroCusto
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto
     * @return SolicitacaoItem
     */
    public function setFkAlmoxarifadoCentroCusto(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto)
    {
        $this->codCentro = $fkAlmoxarifadoCentroCusto->getCodCentro();
        $this->fkAlmoxarifadoCentroCusto = $fkAlmoxarifadoCentroCusto;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCentroCusto
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto
     */
    public function getFkAlmoxarifadoCentroCusto()
    {
        return $this->fkAlmoxarifadoCentroCusto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return SolicitacaoItem
     */
    public function setFkAlmoxarifadoCatalogoItem(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        $this->codItem = $fkAlmoxarifadoCatalogoItem->getCodItem();
        $this->fkAlmoxarifadoCatalogoItem = $fkAlmoxarifadoCatalogoItem;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    public function getFkAlmoxarifadoCatalogoItem()
    {
        return $this->fkAlmoxarifadoCatalogoItem;
    }

    public function __toString()
    {
        if (is_null($this->codSolicitacao)) {
            return 'selecionado';
        }
        return sprintf(
            '%s - %s',
            $this->codItem,
            $this->fkAlmoxarifadoCatalogoItem->getDescricaoResumida()
        );
    }
}
