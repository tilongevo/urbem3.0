<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * CentroCusto
 */
class CentroCusto
{
    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $dtVigencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade
     */
    private $fkAlmoxarifadoCentroCustoEntidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    private $fkAlmoxarifadoEstoqueMateriais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem
     */
    private $fkAlmoxarifadoPedidoTransferenciaItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoPermissao
     */
    private $fkAlmoxarifadoCentroCustoPermissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino
     */
    private $fkAlmoxarifadoPedidoTransferenciaItemDestinos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemItem
     */
    private $fkComprasOrdemItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem
     */
    private $fkComprasSolicitacaoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho
     */
    private $fkEmpenhoItemPreEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcessos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoCentroCustoEntidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoEstoqueMateriais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoPedidoTransferenciaItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoCentroCustoPermissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoPedidoTransferenciaItemDestinos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasOrdemItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasSolicitacaoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoItemPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwProcessos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCentro
     *
     * @param integer $codCentro
     * @return CentroCusto
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
     * Set descricao
     *
     * @param string $descricao
     * @return CentroCusto
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
     * Set dtVigencia
     *
     * @param \DateTime $dtVigencia
     * @return CentroCusto
     */
    public function setDtVigencia(\DateTime $dtVigencia = null)
    {
        $this->dtVigencia = $dtVigencia;
        return $this;
    }

    /**
     * Get dtVigencia
     *
     * @return \DateTime
     */
    public function getDtVigencia()
    {
        return $this->dtVigencia;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoCentroCustoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade $fkAlmoxarifadoCentroCustoEntidade
     * @return CentroCusto
     */
    public function addFkAlmoxarifadoCentroCustoEntidades(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade $fkAlmoxarifadoCentroCustoEntidade)
    {
        if (false === $this->fkAlmoxarifadoCentroCustoEntidades->contains($fkAlmoxarifadoCentroCustoEntidade)) {
            $fkAlmoxarifadoCentroCustoEntidade->setFkAlmoxarifadoCentroCusto($this);
            $this->fkAlmoxarifadoCentroCustoEntidades->add($fkAlmoxarifadoCentroCustoEntidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCentroCustoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade $fkAlmoxarifadoCentroCustoEntidade
     */
    public function removeFkAlmoxarifadoCentroCustoEntidades(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade $fkAlmoxarifadoCentroCustoEntidade)
    {
        $this->fkAlmoxarifadoCentroCustoEntidades->removeElement($fkAlmoxarifadoCentroCustoEntidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCentroCustoEntidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade
     */
    public function getFkAlmoxarifadoCentroCustoEntidades()
    {
        return $this->fkAlmoxarifadoCentroCustoEntidades;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoEstoqueMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial
     * @return CentroCusto
     */
    public function addFkAlmoxarifadoEstoqueMateriais(\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial)
    {
        if (false === $this->fkAlmoxarifadoEstoqueMateriais->contains($fkAlmoxarifadoEstoqueMaterial)) {
            $fkAlmoxarifadoEstoqueMaterial->setFkAlmoxarifadoCentroCusto($this);
            $this->fkAlmoxarifadoEstoqueMateriais->add($fkAlmoxarifadoEstoqueMaterial);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoEstoqueMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial
     */
    public function removeFkAlmoxarifadoEstoqueMateriais(\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial $fkAlmoxarifadoEstoqueMaterial)
    {
        $this->fkAlmoxarifadoEstoqueMateriais->removeElement($fkAlmoxarifadoEstoqueMaterial);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoEstoqueMateriais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial
     */
    public function getFkAlmoxarifadoEstoqueMateriais()
    {
        return $this->fkAlmoxarifadoEstoqueMateriais;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoPedidoTransferenciaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem
     * @return CentroCusto
     */
    public function addFkAlmoxarifadoPedidoTransferenciaItens(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem)
    {
        if (false === $this->fkAlmoxarifadoPedidoTransferenciaItens->contains($fkAlmoxarifadoPedidoTransferenciaItem)) {
            $fkAlmoxarifadoPedidoTransferenciaItem->setFkAlmoxarifadoCentroCusto($this);
            $this->fkAlmoxarifadoPedidoTransferenciaItens->add($fkAlmoxarifadoPedidoTransferenciaItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoPedidoTransferenciaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem
     */
    public function removeFkAlmoxarifadoPedidoTransferenciaItens(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem)
    {
        $this->fkAlmoxarifadoPedidoTransferenciaItens->removeElement($fkAlmoxarifadoPedidoTransferenciaItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoPedidoTransferenciaItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem
     */
    public function getFkAlmoxarifadoPedidoTransferenciaItens()
    {
        return $this->fkAlmoxarifadoPedidoTransferenciaItens;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoCentroCustoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoPermissao $fkAlmoxarifadoCentroCustoPermissao
     * @return CentroCusto
     */
    public function addFkAlmoxarifadoCentroCustoPermissoes(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoPermissao $fkAlmoxarifadoCentroCustoPermissao)
    {
        if (false === $this->fkAlmoxarifadoCentroCustoPermissoes->contains($fkAlmoxarifadoCentroCustoPermissao)) {
            $fkAlmoxarifadoCentroCustoPermissao->setFkAlmoxarifadoCentroCusto($this);
            $this->fkAlmoxarifadoCentroCustoPermissoes->add($fkAlmoxarifadoCentroCustoPermissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCentroCustoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoPermissao $fkAlmoxarifadoCentroCustoPermissao
     */
    public function removeFkAlmoxarifadoCentroCustoPermissoes(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoPermissao $fkAlmoxarifadoCentroCustoPermissao)
    {
        $this->fkAlmoxarifadoCentroCustoPermissoes->removeElement($fkAlmoxarifadoCentroCustoPermissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCentroCustoPermissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoPermissao
     */
    public function getFkAlmoxarifadoCentroCustoPermissoes()
    {
        return $this->fkAlmoxarifadoCentroCustoPermissoes;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoPedidoTransferenciaItemDestino
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino $fkAlmoxarifadoPedidoTransferenciaItemDestino
     * @return CentroCusto
     */
    public function addFkAlmoxarifadoPedidoTransferenciaItemDestinos(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino $fkAlmoxarifadoPedidoTransferenciaItemDestino)
    {
        if (false === $this->fkAlmoxarifadoPedidoTransferenciaItemDestinos->contains($fkAlmoxarifadoPedidoTransferenciaItemDestino)) {
            $fkAlmoxarifadoPedidoTransferenciaItemDestino->setFkAlmoxarifadoCentroCusto($this);
            $this->fkAlmoxarifadoPedidoTransferenciaItemDestinos->add($fkAlmoxarifadoPedidoTransferenciaItemDestino);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoPedidoTransferenciaItemDestino
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino $fkAlmoxarifadoPedidoTransferenciaItemDestino
     */
    public function removeFkAlmoxarifadoPedidoTransferenciaItemDestinos(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino $fkAlmoxarifadoPedidoTransferenciaItemDestino)
    {
        $this->fkAlmoxarifadoPedidoTransferenciaItemDestinos->removeElement($fkAlmoxarifadoPedidoTransferenciaItemDestino);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoPedidoTransferenciaItemDestinos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino
     */
    public function getFkAlmoxarifadoPedidoTransferenciaItemDestinos()
    {
        return $this->fkAlmoxarifadoPedidoTransferenciaItemDestinos;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasOrdemItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem
     * @return CentroCusto
     */
    public function addFkComprasOrdemItens(\Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem)
    {
        if (false === $this->fkComprasOrdemItens->contains($fkComprasOrdemItem)) {
            $fkComprasOrdemItem->setFkAlmoxarifadoCentroCusto($this);
            $this->fkComprasOrdemItens->add($fkComprasOrdemItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasOrdemItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem
     */
    public function removeFkComprasOrdemItens(\Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem)
    {
        $this->fkComprasOrdemItens->removeElement($fkComprasOrdemItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasOrdemItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemItem
     */
    public function getFkComprasOrdemItens()
    {
        return $this->fkComprasOrdemItens;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasSolicitacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem
     * @return CentroCusto
     */
    public function addFkComprasSolicitacaoItens(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem)
    {
        if (false === $this->fkComprasSolicitacaoItens->contains($fkComprasSolicitacaoItem)) {
            $fkComprasSolicitacaoItem->setFkAlmoxarifadoCentroCusto($this);
            $this->fkComprasSolicitacaoItens->add($fkComprasSolicitacaoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasSolicitacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem
     */
    public function removeFkComprasSolicitacaoItens(\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem $fkComprasSolicitacaoItem)
    {
        $this->fkComprasSolicitacaoItens->removeElement($fkComprasSolicitacaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasSolicitacaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\SolicitacaoItem
     */
    public function getFkComprasSolicitacaoItens()
    {
        return $this->fkComprasSolicitacaoItens;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho
     * @return CentroCusto
     */
    public function addFkEmpenhoItemPreEmpenhos(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho $fkEmpenhoItemPreEmpenho)
    {
        if (false === $this->fkEmpenhoItemPreEmpenhos->contains($fkEmpenhoItemPreEmpenho)) {
            $fkEmpenhoItemPreEmpenho->setFkAlmoxarifadoCentroCusto($this);
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
     * Add SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return CentroCusto
     */
    public function addFkSwProcessos(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        if (false === $this->fkSwProcessos->contains($fkSwProcesso)) {
            $fkSwProcesso->setFkAlmoxarifadoCentroCusto($this);
            $this->fkSwProcessos->add($fkSwProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     */
    public function removeFkSwProcessos(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->fkSwProcessos->removeElement($fkSwProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcessos()
    {
        return $this->fkSwProcessos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strtoupper($this->descricao);
    }
}
