<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * PedidoTransferenciaItemDestino
 */
class PedidoTransferenciaItemDestino
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
     * PK
     * @var integer
     */
    private $codCentroDestino;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItemDestino
     */
    private $fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem
     */
    private $fkAlmoxarifadoPedidoTransferenciaItem;

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
        $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PedidoTransferenciaItemDestino
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
     * @return PedidoTransferenciaItemDestino
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
     * @return PedidoTransferenciaItemDestino
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
     * @return PedidoTransferenciaItemDestino
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
     * @return PedidoTransferenciaItemDestino
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
     * Set codCentroDestino
     *
     * @param integer $codCentroDestino
     * @return PedidoTransferenciaItemDestino
     */
    public function setCodCentroDestino($codCentroDestino)
    {
        $this->codCentroDestino = $codCentroDestino;
        return $this;
    }

    /**
     * Get codCentroDestino
     *
     * @return integer
     */
    public function getCodCentroDestino()
    {
        return $this->codCentroDestino;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoTransferenciaAlmoxarifadoItemDestino
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItemDestino $fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino
     * @return PedidoTransferenciaItemDestino
     */
    public function addFkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos(\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItemDestino $fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino)
    {
        if (false === $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos->contains($fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino)) {
            $fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino->setFkAlmoxarifadoPedidoTransferenciaItemDestino($this);
            $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos->add($fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoTransferenciaAlmoxarifadoItemDestino
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItemDestino $fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino
     */
    public function removeFkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos(\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItemDestino $fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino)
    {
        $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos->removeElement($fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestino);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\TransferenciaAlmoxarifadoItemDestino
     */
    public function getFkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos()
    {
        return $this->fkAlmoxarifadoTransferenciaAlmoxarifadoItemDestinos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoPedidoTransferenciaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem
     * @return PedidoTransferenciaItemDestino
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

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCentroCusto
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto
     * @return PedidoTransferenciaItemDestino
     */
    public function setFkAlmoxarifadoCentroCusto(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto)
    {
        $this->codCentroDestino = $fkAlmoxarifadoCentroCusto->getCodCentro();
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
}
