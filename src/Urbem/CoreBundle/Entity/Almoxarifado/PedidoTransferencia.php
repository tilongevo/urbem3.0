<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * PedidoTransferencia
 */
class PedidoTransferencia
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
     * @var integer
     */
    private $cgmAlmoxarife;

    /**
     * @var integer
     */
    private $codAlmoxarifadoOrigem;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codAlmoxarifadoDestino;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaAnulacao
     */
    private $fkAlmoxarifadoPedidoTransferenciaAnulacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem
     */
    private $fkAlmoxarifadoPedidoTransferenciaItens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife
     */
    private $fkAlmoxarifadoAlmoxarife;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    private $fkAlmoxarifadoAlmoxarifado;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    private $fkAlmoxarifadoAlmoxarifado1;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoPedidoTransferenciaItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PedidoTransferencia
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
     * @return PedidoTransferencia
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
     * Set cgmAlmoxarife
     *
     * @param integer $cgmAlmoxarife
     * @return PedidoTransferencia
     */
    public function setCgmAlmoxarife($cgmAlmoxarife)
    {
        $this->cgmAlmoxarife = $cgmAlmoxarife;
        return $this;
    }

    /**
     * Get cgmAlmoxarife
     *
     * @return integer
     */
    public function getCgmAlmoxarife()
    {
        return $this->cgmAlmoxarife;
    }

    /**
     * Set codAlmoxarifadoOrigem
     *
     * @param integer $codAlmoxarifadoOrigem
     * @return PedidoTransferencia
     */
    public function setCodAlmoxarifadoOrigem($codAlmoxarifadoOrigem)
    {
        $this->codAlmoxarifadoOrigem = $codAlmoxarifadoOrigem;
        return $this;
    }

    /**
     * Get codAlmoxarifadoOrigem
     *
     * @return integer
     */
    public function getCodAlmoxarifadoOrigem()
    {
        return $this->codAlmoxarifadoOrigem;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return PedidoTransferencia
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return PedidoTransferencia
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codAlmoxarifadoDestino
     *
     * @param integer $codAlmoxarifadoDestino
     * @return PedidoTransferencia
     */
    public function setCodAlmoxarifadoDestino($codAlmoxarifadoDestino)
    {
        $this->codAlmoxarifadoDestino = $codAlmoxarifadoDestino;
        return $this;
    }

    /**
     * Get codAlmoxarifadoDestino
     *
     * @return integer
     */
    public function getCodAlmoxarifadoDestino()
    {
        return $this->codAlmoxarifadoDestino;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoPedidoTransferenciaItem
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem
     * @return PedidoTransferencia
     */
    public function addFkAlmoxarifadoPedidoTransferenciaItens(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaItem $fkAlmoxarifadoPedidoTransferenciaItem)
    {
        if (false === $this->fkAlmoxarifadoPedidoTransferenciaItens->contains($fkAlmoxarifadoPedidoTransferenciaItem)) {
            $fkAlmoxarifadoPedidoTransferenciaItem->setFkAlmoxarifadoPedidoTransferencia($this);
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
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoAlmoxarife
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife $fkAlmoxarifadoAlmoxarife
     * @return PedidoTransferencia
     */
    public function setFkAlmoxarifadoAlmoxarife(\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife $fkAlmoxarifadoAlmoxarife)
    {
        $this->cgmAlmoxarife = $fkAlmoxarifadoAlmoxarife->getCgmAlmoxarife();
        $this->fkAlmoxarifadoAlmoxarife = $fkAlmoxarifadoAlmoxarife;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoAlmoxarife
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife
     */
    public function getFkAlmoxarifadoAlmoxarife()
    {
        return $this->fkAlmoxarifadoAlmoxarife;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoAlmoxarifado
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado
     * @return PedidoTransferencia
     */
    public function setFkAlmoxarifadoAlmoxarifado(\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado)
    {
        $this->codAlmoxarifadoOrigem = $fkAlmoxarifadoAlmoxarifado->getCodAlmoxarifado();
        $this->fkAlmoxarifadoAlmoxarifado = $fkAlmoxarifadoAlmoxarifado;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoAlmoxarifado
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    public function getFkAlmoxarifadoAlmoxarifado()
    {
        return $this->fkAlmoxarifadoAlmoxarifado;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoAlmoxarifado1
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado1
     * @return PedidoTransferencia
     */
    public function setFkAlmoxarifadoAlmoxarifado1(\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado $fkAlmoxarifadoAlmoxarifado1)
    {
        $this->codAlmoxarifadoDestino = $fkAlmoxarifadoAlmoxarifado1->getCodAlmoxarifado();
        $this->fkAlmoxarifadoAlmoxarifado1 = $fkAlmoxarifadoAlmoxarifado1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoAlmoxarifado1
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado
     */
    public function getFkAlmoxarifadoAlmoxarifado1()
    {
        return $this->fkAlmoxarifadoAlmoxarifado1;
    }

    /**
     * OneToOne (inverse side)
     * Set AlmoxarifadoPedidoTransferenciaAnulacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaAnulacao $fkAlmoxarifadoPedidoTransferenciaAnulacao
     * @return PedidoTransferencia
     */
    public function setFkAlmoxarifadoPedidoTransferenciaAnulacao(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaAnulacao $fkAlmoxarifadoPedidoTransferenciaAnulacao)
    {
        $fkAlmoxarifadoPedidoTransferenciaAnulacao->setFkAlmoxarifadoPedidoTransferencia($this);
        $this->fkAlmoxarifadoPedidoTransferenciaAnulacao = $fkAlmoxarifadoPedidoTransferenciaAnulacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkAlmoxarifadoPedidoTransferenciaAnulacao
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferenciaAnulacao
     */
    public function getFkAlmoxarifadoPedidoTransferenciaAnulacao()
    {
        return $this->fkAlmoxarifadoPedidoTransferenciaAnulacao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('Pedido Transferência %s', $this->codTransferencia);
    }
}
