<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TransferenciaCancelamento
 */
class TransferenciaCancelamento
{
    /**
     * PK
     * @var integer
     */
    private $codTransferencia;

    /**
     * @var \DateTime
     */
    private $dtCancelamento;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel
     */
    private $fkImobiliarioTransferenciaImovel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtCancelamento = new \DateTime;
    }

    /**
     * Set codTransferencia
     *
     * @param integer $codTransferencia
     * @return TransferenciaCancelamento
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
     * Set dtCancelamento
     *
     * @param \DateTime $dtCancelamento
     * @return TransferenciaCancelamento
     */
    public function setDtCancelamento(\DateTime $dtCancelamento)
    {
        $this->dtCancelamento = $dtCancelamento;
        return $this;
    }

    /**
     * Get dtCancelamento
     *
     * @return \DateTime
     */
    public function getDtCancelamento()
    {
        return $this->dtCancelamento;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return TransferenciaCancelamento
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioTransferenciaImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel
     * @return TransferenciaCancelamento
     */
    public function setFkImobiliarioTransferenciaImovel(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel $fkImobiliarioTransferenciaImovel)
    {
        $this->codTransferencia = $fkImobiliarioTransferenciaImovel->getCodTransferencia();
        $this->fkImobiliarioTransferenciaImovel = $fkImobiliarioTransferenciaImovel;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioTransferenciaImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel
     */
    public function getFkImobiliarioTransferenciaImovel()
    {
        return $this->fkImobiliarioTransferenciaImovel;
    }
}
