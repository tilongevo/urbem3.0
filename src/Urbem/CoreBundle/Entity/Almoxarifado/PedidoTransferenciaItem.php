<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * PedidoTransferenciaItem
 */
class PedidoTransferenciaItem
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
    private $codTransferencia;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var integer
     */
    private $codMarca;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItem
     */
    private $fkAlmoxarifadoAtributoPedidoTransferenciaItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino
     */
    private $fkAlmoxarifadoPedidoTransferenciaItemDestinos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItem
     */
    private $fkAlmoxarifadoTransferenciaAlmoxarifadoItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia
     */
    private $fkAlmoxarifadoPedidoTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem
     */
    private $fkAlmoxarifadoCatalogoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Marca
     */
    private $fkAlmoxarifadoMarca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto
     */
    private $fkAlmoxarifadoCentroCusto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoAtributoPedidoTransferenciaItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoPedidoTransferenciaItemDestinos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PedidoTransferenciaItem
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
     * Set codTransferencia
     *
     * @param integer $codTransferencia
     * @return PedidoTransferenciaItem
     */
    public function setCodTransferencia($codTransferencia)
    {
        $this->codTransferencia = $codTransferencia;
        return $this;
    }

    /**
     * Get codTransferencia
     *
     * @return integer
     */
    public function getCodTransferencia()
    {
        return $this->codTransferencia;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return PedidoTransferenciaItem
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
     * Set codMarca
     *
     * @param integer $codMarca
     * @return PedidoTransferenciaItem
     */
    public function setCodMarca($codMarca)
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
     * Set codCentro
     *
     * @param integer $codCentro
     * @return PedidoTransferenciaItem
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return PedidoTransferenciaItem
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
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoPedidoTransferenciaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItem $fkAlmoxarifadoAtributoPedidoTransferenciaItem
     * @return PedidoTransferenciaItem
     */
    public function addFkAlmoxarifadoAtributoPedidoTransferenciaItens(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItem $fkAlmoxarifadoAtributoPedidoTransferenciaItem)
    {
        if (false === $this->fkAlmoxarifadoAtributoPedidoTransferenciaItens->contains($fkAlmoxarifadoAtributoPedidoTransferenciaItem)) {
            $fkAlmoxarifadoAtributoPedidoTransferenciaItem->setFkAlmoxarifadoPedidoTransferenciaItem($this);
            $this->fkAlmoxarifadoAtributoPedidoTransferenciaItens->add($fkAlmoxarifadoAtributoPedidoTransferenciaItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoPedidoTransferenciaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItem $fkAlmoxarifadoAtributoPedidoTransferenciaItem
     */
    public function removeFkAlmoxarifadoAtributoPedidoTransferenciaItens(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItem $fkAlmoxarifadoAtributoPedidoTransferenciaItem)
    {
        $this->fkAlmoxarifadoAtributoPedidoTransferenciaItens->removeElement($fkAlmoxarifadoAtributoPedidoTransferenciaItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoPedidoTransferenciaItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItem
     */
    public function getFkAlmoxarifadoAtributoPedidoTransferenciaItens()
    {
        return $this->fkAlmoxarifadoAtributoPedidoTransferenciaItens;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoPedidoTransferenciaItemDestino
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino $fkAlmoxarifadoPedidoTransferenciaItemDestino
     * @return PedidoTransferenciaItem
     */
    public function addFkAlmoxarifadoPedidoTransferenciaItemDestinos(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItemDestino $fkAlmoxarifadoPedidoTransferenciaItemDestino)
    {
        if (false === $this->fkAlmoxarifadoPedidoTransferenciaItemDestinos->contains($fkAlmoxarifadoPedidoTransferenciaItemDestino)) {
            $fkAlmoxarifadoPedidoTransferenciaItemDestino->setFkAlmoxarifadoPedidoTransferenciaItem($this);
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
     * Add AlmoxarifadoTransferenciaAlmoxarifadoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItem $fkAlmoxarifadoTransferenciaAlmoxarifadoItem
     * @return PedidoTransferenciaItem
     */
    public function addFkAlmoxarifadoTransferenciaAlmoxarifadoItens(\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItem $fkAlmoxarifadoTransferenciaAlmoxarifadoItem)
    {
        if (false === $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItens->contains($fkAlmoxarifadoTransferenciaAlmoxarifadoItem)) {
            $fkAlmoxarifadoTransferenciaAlmoxarifadoItem->setFkAlmoxarifadoPedidoTransferenciaItem($this);
            $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItens->add($fkAlmoxarifadoTransferenciaAlmoxarifadoItem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoTransferenciaAlmoxarifadoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItem $fkAlmoxarifadoTransferenciaAlmoxarifadoItem
     */
    public function removeFkAlmoxarifadoTransferenciaAlmoxarifadoItens(\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItem $fkAlmoxarifadoTransferenciaAlmoxarifadoItem)
    {
        $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItens->removeElement($fkAlmoxarifadoTransferenciaAlmoxarifadoItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoTransferenciaAlmoxarifadoItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItem
     */
    public function getFkAlmoxarifadoTransferenciaAlmoxarifadoItens()
    {
        return $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoPedidoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia
     * @return PedidoTransferenciaItem
     */
    public function setFkAlmoxarifadoPedidoTransferencia(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia)
    {
        $this->exercicio = $fkAlmoxarifadoPedidoTransferencia->getExercicio();
        $this->codTransferencia = $fkAlmoxarifadoPedidoTransferencia->getCodTransferencia();
        $this->fkAlmoxarifadoPedidoTransferencia = $fkAlmoxarifadoPedidoTransferencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoPedidoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia
     */
    public function getFkAlmoxarifadoPedidoTransferencia()
    {
        return $this->fkAlmoxarifadoPedidoTransferencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem $fkAlmoxarifadoCatalogoItem
     * @return PedidoTransferenciaItem
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
     * Set fkAlmoxarifadoMarca
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Marca $fkAlmoxarifadoMarca
     * @return PedidoTransferenciaItem
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
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCentroCusto
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto
     * @return PedidoTransferenciaItem
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkAlmoxarifadoCatalogoItem;
    }
}
