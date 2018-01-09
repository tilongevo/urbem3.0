<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * AtributoPedidoTransferenciaItem
 */
class AtributoPedidoTransferenciaItem
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
    private $codSequencial;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItemValor
     */
    private $fkAlmoxarifadoAtributoPedidoTransferenciaItemValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem
     */
    private $fkAlmoxarifadoPedidoTransferenciaItem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoAtributoPedidoTransferenciaItemValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AtributoPedidoTransferenciaItem
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
     * @return AtributoPedidoTransferenciaItem
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
     * Set codSequencial
     *
     * @param integer $codSequencial
     * @return AtributoPedidoTransferenciaItem
     */
    public function setCodSequencial($codSequencial)
    {
        $this->codSequencial = $codSequencial;
        return $this;
    }

    /**
     * Get codSequencial
     *
     * @return integer
     */
    public function getCodSequencial()
    {
        return $this->codSequencial;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return AtributoPedidoTransferenciaItem
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
     * @return AtributoPedidoTransferenciaItem
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
     * @return AtributoPedidoTransferenciaItem
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
     * @return AtributoPedidoTransferenciaItem
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
     * OneToMany (owning side)
     * Add AlmoxarifadoAtributoPedidoTransferenciaItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItemValor $fkAlmoxarifadoAtributoPedidoTransferenciaItemValor
     * @return AtributoPedidoTransferenciaItem
     */
    public function addFkAlmoxarifadoAtributoPedidoTransferenciaItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItemValor $fkAlmoxarifadoAtributoPedidoTransferenciaItemValor)
    {
        if (false === $this->fkAlmoxarifadoAtributoPedidoTransferenciaItemValores->contains($fkAlmoxarifadoAtributoPedidoTransferenciaItemValor)) {
            $fkAlmoxarifadoAtributoPedidoTransferenciaItemValor->setFkAlmoxarifadoAtributoPedidoTransferenciaItem($this);
            $this->fkAlmoxarifadoAtributoPedidoTransferenciaItemValores->add($fkAlmoxarifadoAtributoPedidoTransferenciaItemValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoAtributoPedidoTransferenciaItemValor
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItemValor $fkAlmoxarifadoAtributoPedidoTransferenciaItemValor
     */
    public function removeFkAlmoxarifadoAtributoPedidoTransferenciaItemValores(\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItemValor $fkAlmoxarifadoAtributoPedidoTransferenciaItemValor)
    {
        $this->fkAlmoxarifadoAtributoPedidoTransferenciaItemValores->removeElement($fkAlmoxarifadoAtributoPedidoTransferenciaItemValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoAtributoPedidoTransferenciaItemValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\AtributoPedidoTransferenciaItemValor
     */
    public function getFkAlmoxarifadoAtributoPedidoTransferenciaItemValores()
    {
        return $this->fkAlmoxarifadoAtributoPedidoTransferenciaItemValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoPedidoTransferenciaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem
     * @return AtributoPedidoTransferenciaItem
     */
    public function setFkAlmoxarifadoPedidoTransferenciaItem(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem)
    {
        $this->exercicio = $fkAlmoxarifadoPedidoTransferenciaItem->getExercicio();
        $this->codTransferencia = $fkAlmoxarifadoPedidoTransferenciaItem->getCodTransferencia();
        $this->codItem = $fkAlmoxarifadoPedidoTransferenciaItem->getCodItem();
        $this->codMarca = $fkAlmoxarifadoPedidoTransferenciaItem->getCodMarca();
        $this->codCentro = $fkAlmoxarifadoPedidoTransferenciaItem->getCodCentro();
        $this->fkAlmoxarifadoPedidoTransferenciaItem = $fkAlmoxarifadoPedidoTransferenciaItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoPedidoTransferenciaItem
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem
     */
    public function getFkAlmoxarifadoPedidoTransferenciaItem()
    {
        return $this->fkAlmoxarifadoPedidoTransferenciaItem;
    }
}
