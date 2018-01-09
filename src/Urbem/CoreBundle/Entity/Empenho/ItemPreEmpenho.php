<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * ItemPreEmpenho
 */
class ItemPreEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numItem;

    /**
     * @var integer
     */
    private $codUnidade;

    /**
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
    private $siglaUnidade;

    /**
     * @var string
     */
    private $nomItem;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $vlTotal;

    /**
     * @var string
     */
    private $complemento;

    /**
     * @var integer
     */
    private $codItem;

    /**
     * @var integer
     */
    private $codCentro;

    /**
     * @var integer
     */
    private $codMarca;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoCompra
     */
    private $fkEmpenhoItemPreEmpenhoCompra;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoJulgamento
     */
    private $fkEmpenhoItemPreEmpenhoJulgamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\OrdemItem
     */
    private $fkComprasOrdemItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem
     */
    private $fkEmpenhoEmpenhoAnuladoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem
     */
    private $fkEmpenhoNotaLiquidacaoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem
     */
    private $fkTcemgContratoAditivoItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemEmpenhoDespesasFixas
     */
    private $fkEmpenhoItemEmpenhoDespesasFixas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    private $fkEmpenhoPreEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    private $fkAdministracaoUnidadeMedida;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto
     */
    private $fkAlmoxarifadoCentroCusto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Marca
     */
    private $fkAlmoxarifadoMarca;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasOrdemItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoEmpenhoAnuladoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoNotaLiquidacaoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratoAditivoItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoItemEmpenhoDespesasFixas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return ItemPreEmpenho
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ItemPreEmpenho
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
     * Set numItem
     *
     * @param integer $numItem
     * @return ItemPreEmpenho
     */
    public function setNumItem($numItem)
    {
        $this->numItem = $numItem;
        return $this;
    }

    /**
     * Get numItem
     *
     * @return integer
     */
    public function getNumItem()
    {
        return $this->numItem;
    }

    /**
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return ItemPreEmpenho
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
     * @return ItemPreEmpenho
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
     * @return ItemPreEmpenho
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
     * Set siglaUnidade
     *
     * @param string $siglaUnidade
     * @return ItemPreEmpenho
     */
    public function setSiglaUnidade($siglaUnidade)
    {
        $this->siglaUnidade = $siglaUnidade;
        return $this;
    }

    /**
     * Get siglaUnidade
     *
     * @return string
     */
    public function getSiglaUnidade()
    {
        return $this->siglaUnidade;
    }

    /**
     * Set nomItem
     *
     * @param string $nomItem
     * @return ItemPreEmpenho
     */
    public function setNomItem($nomItem)
    {
        $this->nomItem = $nomItem;
        return $this;
    }

    /**
     * Get nomItem
     *
     * @return string
     */
    public function getNomItem()
    {
        return $this->nomItem;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return ItemPreEmpenho
     */
    public function setQuantidade($quantidade)
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
     * @return ItemPreEmpenho
     */
    public function setVlTotal($vlTotal)
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
     * Set complemento
     *
     * @param string $complemento
     * @return ItemPreEmpenho
     */
    public function setComplemento($complemento)
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
     * Set codItem
     *
     * @param integer $codItem
     * @return ItemPreEmpenho
     */
    public function setCodItem($codItem = null)
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
     * Set codCentro
     *
     * @param integer $codCentro
     * @return ItemPreEmpenho
     */
    public function setCodCentro($codCentro = null)
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
     * Set codMarca
     *
     * @param integer $codMarca
     * @return ItemPreEmpenho
     */
    public function setCodMarca($codMarca = null)
    {
        $this->codMarca = $codMarca;
        return $this;
    }

    /**
     * Get codMarca
     *
     * @return integer
     */
    public function getCodMarca()
    {
        return $this->codMarca;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasOrdemItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem
     * @return ItemPreEmpenho
     */
    public function addFkComprasOrdemItens(\Urbem\CoreBundle\Entity\Compras\OrdemItem $fkComprasOrdemItem)
    {
        if (false === $this->fkComprasOrdemItens->contains($fkComprasOrdemItem)) {
            $fkComprasOrdemItem->setFkEmpenhoItemPreEmpenho($this);
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
     * Add EmpenhoEmpenhoAnuladoItem
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem $fkEmpenhoEmpenhoAnuladoItem
     * @return ItemPreEmpenho
     */
    public function addFkEmpenhoEmpenhoAnuladoItens(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem $fkEmpenhoEmpenhoAnuladoItem)
    {
        if (false === $this->fkEmpenhoEmpenhoAnuladoItens->contains($fkEmpenhoEmpenhoAnuladoItem)) {
            $fkEmpenhoEmpenhoAnuladoItem->setFkEmpenhoItemPreEmpenho($this);
            $this->fkEmpenhoEmpenhoAnuladoItens->add($fkEmpenhoEmpenhoAnuladoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoEmpenhoAnuladoItem
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem $fkEmpenhoEmpenhoAnuladoItem
     */
    public function removeFkEmpenhoEmpenhoAnuladoItens(\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem $fkEmpenhoEmpenhoAnuladoItem)
    {
        $this->fkEmpenhoEmpenhoAnuladoItens->removeElement($fkEmpenhoEmpenhoAnuladoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoEmpenhoAnuladoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\EmpenhoAnuladoItem
     */
    public function getFkEmpenhoEmpenhoAnuladoItens()
    {
        return $this->fkEmpenhoEmpenhoAnuladoItens;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoNotaLiquidacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem $fkEmpenhoNotaLiquidacaoItem
     * @return ItemPreEmpenho
     */
    public function addFkEmpenhoNotaLiquidacaoItens(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem $fkEmpenhoNotaLiquidacaoItem)
    {
        if (false === $this->fkEmpenhoNotaLiquidacaoItens->contains($fkEmpenhoNotaLiquidacaoItem)) {
            $fkEmpenhoNotaLiquidacaoItem->setFkEmpenhoItemPreEmpenho($this);
            $this->fkEmpenhoNotaLiquidacaoItens->add($fkEmpenhoNotaLiquidacaoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoNotaLiquidacaoItem
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem $fkEmpenhoNotaLiquidacaoItem
     */
    public function removeFkEmpenhoNotaLiquidacaoItens(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem $fkEmpenhoNotaLiquidacaoItem)
    {
        $this->fkEmpenhoNotaLiquidacaoItens->removeElement($fkEmpenhoNotaLiquidacaoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoNotaLiquidacaoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItem
     */
    public function getFkEmpenhoNotaLiquidacaoItens()
    {
        return $this->fkEmpenhoNotaLiquidacaoItens;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContratoAditivoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem
     * @return ItemPreEmpenho
     */
    public function addFkTcemgContratoAditivoItens(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem)
    {
        if (false === $this->fkTcemgContratoAditivoItens->contains($fkTcemgContratoAditivoItem)) {
            $fkTcemgContratoAditivoItem->setFkEmpenhoItemPreEmpenho($this);
            $this->fkTcemgContratoAditivoItens->add($fkTcemgContratoAditivoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoAditivoItem
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem
     */
    public function removeFkTcemgContratoAditivoItens(\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem $fkTcemgContratoAditivoItem)
    {
        $this->fkTcemgContratoAditivoItens->removeElement($fkTcemgContratoAditivoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoAditivoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem
     */
    public function getFkTcemgContratoAditivoItens()
    {
        return $this->fkTcemgContratoAditivoItens;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoItemEmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemEmpenhoDespesasFixas $fkEmpenhoItemEmpenhoDespesasFixas
     * @return ItemPreEmpenho
     */
    public function addFkEmpenhoItemEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\ItemEmpenhoDespesasFixas $fkEmpenhoItemEmpenhoDespesasFixas)
    {
        if (false === $this->fkEmpenhoItemEmpenhoDespesasFixas->contains($fkEmpenhoItemEmpenhoDespesasFixas)) {
            $fkEmpenhoItemEmpenhoDespesasFixas->setFkEmpenhoItemPreEmpenho($this);
            $this->fkEmpenhoItemEmpenhoDespesasFixas->add($fkEmpenhoItemEmpenhoDespesasFixas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoItemEmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemEmpenhoDespesasFixas $fkEmpenhoItemEmpenhoDespesasFixas
     */
    public function removeFkEmpenhoItemEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\ItemEmpenhoDespesasFixas $fkEmpenhoItemEmpenhoDespesasFixas)
    {
        $this->fkEmpenhoItemEmpenhoDespesasFixas->removeElement($fkEmpenhoItemEmpenhoDespesasFixas);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoItemEmpenhoDespesasFixas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemEmpenhoDespesasFixas
     */
    public function getFkEmpenhoItemEmpenhoDespesasFixas()
    {
        return $this->fkEmpenhoItemEmpenhoDespesasFixas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho
     * @return ItemPreEmpenho
     */
    public function setFkEmpenhoPreEmpenho(\Urbem\CoreBundle\Entity\Empenho\PreEmpenho $fkEmpenhoPreEmpenho)
    {
        $this->exercicio = $fkEmpenhoPreEmpenho->getExercicio();
        $this->codPreEmpenho = $fkEmpenhoPreEmpenho->getCodPreEmpenho();
        $this->fkEmpenhoPreEmpenho = $fkEmpenhoPreEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoPreEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\PreEmpenho
     */
    public function getFkEmpenhoPreEmpenho()
    {
        return $this->fkEmpenhoPreEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUnidadeMedida
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida
     * @return ItemPreEmpenho
     */
    public function setFkAdministracaoUnidadeMedida(\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida)
    {
        $this->codUnidade = $fkAdministracaoUnidadeMedida->getCodUnidade();
        $this->codGrandeza = $fkAdministracaoUnidadeMedida->getCodGrandeza();
        $this->fkAdministracaoUnidadeMedida = $fkAdministracaoUnidadeMedida;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUnidadeMedida
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    public function getFkAdministracaoUnidadeMedida()
    {
        return $this->fkAdministracaoUnidadeMedida;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return ItemPreEmpenho
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

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCentroCusto
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto
     * @return ItemPreEmpenho
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
     * Set fkAlmoxarifadoMarca
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Marca $fkAlmoxarifadoMarca
     * @return ItemPreEmpenho
     */
    public function setFkAlmoxarifadoMarca(\Urbem\CoreBundle\Entity\Almoxarifado\Marca $fkAlmoxarifadoMarca)
    {
        $this->codMarca = $fkAlmoxarifadoMarca->getCodMarca();
        $this->fkAlmoxarifadoMarca = $fkAlmoxarifadoMarca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoMarca
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Marca
     */
    public function getFkAlmoxarifadoMarca()
    {
        return $this->fkAlmoxarifadoMarca;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoItemPreEmpenhoCompra
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoCompra $fkEmpenhoItemPreEmpenhoCompra
     * @return ItemPreEmpenho
     */
    public function setFkEmpenhoItemPreEmpenhoCompra(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoCompra $fkEmpenhoItemPreEmpenhoCompra)
    {
        $fkEmpenhoItemPreEmpenhoCompra->setFkEmpenhoItemPreEmpenho($this);
        $this->fkEmpenhoItemPreEmpenhoCompra = $fkEmpenhoItemPreEmpenhoCompra;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoItemPreEmpenhoCompra
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoCompra
     */
    public function getFkEmpenhoItemPreEmpenhoCompra()
    {
        return $this->fkEmpenhoItemPreEmpenhoCompra;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoItemPreEmpenhoJulgamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoJulgamento $fkEmpenhoItemPreEmpenhoJulgamento
     * @return ItemPreEmpenho
     */
    public function setFkEmpenhoItemPreEmpenhoJulgamento(\Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoJulgamento $fkEmpenhoItemPreEmpenhoJulgamento)
    {
        $fkEmpenhoItemPreEmpenhoJulgamento->setFkEmpenhoItemPreEmpenho($this);
        $this->fkEmpenhoItemPreEmpenhoJulgamento = $fkEmpenhoItemPreEmpenhoJulgamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoItemPreEmpenhoJulgamento
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenhoJulgamento
     */
    public function getFkEmpenhoItemPreEmpenhoJulgamento()
    {
        return $this->fkEmpenhoItemPreEmpenhoJulgamento;
    }

    /**
     * @return float|int
     */
    public function getVlUnitario()
    {
        if (empty($this->getQuantidade())) {
            return $this->getQuantidade();
        } else {
            return $this->getVlTotal()/$this->getQuantidade();
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->numItem;
    }
}
