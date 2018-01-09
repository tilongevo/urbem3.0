<?php

namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * ControleEstoque
 */
class ControleEstoque
{
    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * @var float
     */
    private $estoqueMinimo = 0;

    /**
     * @var float
     */
    private $estoqueMaximo = 0;

    /**
     * @var float
     */
    private $pontoPedido = 0;

    /**
     * @var float
     */
    private $estoqueMinimoCompra = 0;

    /**
     * @var float
     */
    private $estoqueMaximoCompra = 0;

    /**
     * @var float
     */
    private $pontoPedidoCompra = 0;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItem;


    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return ControleEstoque
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
     * Set estoqueMinimo
     *
     * @param float $estoqueMinimo
     * @return ControleEstoque
     */
    public function setEstoqueMinimo($estoqueMinimo)
    {
        $this->estoqueMinimo = $estoqueMinimo;
        return $this;
    }

    /**
     * Get estoqueMinimo
     *
     * @return float
     */
    public function getEstoqueMinimo()
    {
        return $this->estoqueMinimo;
    }

    /**
     * Set estoqueMaximo
     *
     * @param float $estoqueMaximo
     * @return ControleEstoque
     */
    public function setEstoqueMaximo($estoqueMaximo)
    {
        $this->estoqueMaximo = $estoqueMaximo;
        return $this;
    }

    /**
     * Get estoqueMaximo
     *
     * @return float
     */
    public function getEstoqueMaximo()
    {
        return $this->estoqueMaximo;
    }

    /**
     * Set pontoPedido
     *
     * @param float $pontoPedido
     * @return ControleEstoque
     */
    public function setPontoPedido($pontoPedido)
    {
        $this->pontoPedido = $pontoPedido;
        return $this;
    }

    /**
     * Get pontoPedido
     *
     * @return float
     */
    public function getPontoPedido()
    {
        return $this->pontoPedido;
    }

    /**
     * Set estoqueMinimoCompra
     *
     * @param float $estoqueMinimoCompra
     * @return ControleEstoque
     */
    public function setEstoqueMinimoCompra($estoqueMinimoCompra)
    {
        $this->estoqueMinimoCompra = $estoqueMinimoCompra;
        return $this;
    }

    /**
     * Get estoqueMinimoCompra
     *
     * @return float
     */
    public function getEstoqueMinimoCompra()
    {
        return $this->estoqueMinimoCompra;
    }

    /**
     * Set estoqueMaximoCompra
     *
     * @param float $estoqueMaximoCompra
     * @return ControleEstoque
     */
    public function setEstoqueMaximoCompra($estoqueMaximoCompra)
    {
        $this->estoqueMaximoCompra = $estoqueMaximoCompra;
        return $this;
    }

    /**
     * Get estoqueMaximoCompra
     *
     * @return float
     */
    public function getEstoqueMaximoCompra()
    {
        return $this->estoqueMaximoCompra;
    }

    /**
     * Set pontoPedidoCompra
     *
     * @param float $pontoPedidoCompra
     * @return ControleEstoque
     */
    public function setPontoPedidoCompra($pontoPedidoCompra)
    {
        $this->pontoPedidoCompra = $pontoPedidoCompra;
        return $this;
    }

    /**
     * Get pontoPedidoCompra
     *
     * @return float
     */
    public function getPontoPedidoCompra()
    {
        return $this->pontoPedidoCompra;
    }

    /**
     * OneToOne (owning side)
     * Set AlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return ControleEstoque
     */
    public function setFkAlmoxarifadoCatalogoItem(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem)
    {
        $this->codItem = $fkAlmoxarifadoCatalogoItem->getCodItem();
        $this->fkAlmoxarifadoCatalogoItem = $fkAlmoxarifadoCatalogoItem;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAlmoxarifadoCatalogoItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    public function getFkAlmoxarifadoCatalogoItem()
    {
        return $this->fkAlmoxarifadoCatalogoItem;
    }
}
