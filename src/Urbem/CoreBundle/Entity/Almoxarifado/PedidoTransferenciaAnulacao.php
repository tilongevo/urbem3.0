<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * PedidoTransferenciaAnulacao
 */
class PedidoTransferenciaAnulacao
{
    /**
     * PK
     * @var integer
     */
    private $codTransferencia;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia
     */
    private $fkAlmoxarifadoPedidoTransferencia;


    /**
     * Set codTransferencia
     *
     * @param integer $codTransferencia
     * @return PedidoTransferenciaAnulacao
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return PedidoTransferenciaAnulacao
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
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return PedidoTransferenciaAnulacao
     */
    public function setTimestamp(\DateTime $timestamp = null)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToOne (owning side)
     * Set AlmoxarifadoPedidoTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia
     * @return PedidoTransferenciaAnulacao
     */
    public function setFkAlmoxarifadoPedidoTransferencia(\Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia $fkAlmoxarifadoPedidoTransferencia)
    {
        $this->exercicio = $fkAlmoxarifadoPedidoTransferencia->getExercicio();
        $this->codTransferencia = $fkAlmoxarifadoPedidoTransferencia->getCodTransferencia();
        $this->fkAlmoxarifadoPedidoTransferencia = $fkAlmoxarifadoPedidoTransferencia;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAlmoxarifadoPedidoTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\PedidoTransferencia
     */
    public function getFkAlmoxarifadoPedidoTransferencia()
    {
        return $this->fkAlmoxarifadoPedidoTransferencia;
    }
}
