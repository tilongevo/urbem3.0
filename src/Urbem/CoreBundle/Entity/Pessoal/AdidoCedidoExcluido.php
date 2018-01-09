<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AdidoCedidoExcluido
 */
class AdidoCedidoExcluido
{
    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestampCedidoAdido;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AdidoCedido
     */
    private $fkPessoalAdidoCedido;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampCedidoAdido = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return AdidoCedidoExcluido
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return AdidoCedidoExcluido
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set timestampCedidoAdido
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestampCedidoAdido
     * @return AdidoCedidoExcluido
     */
    public function setTimestampCedidoAdido(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampCedidoAdido)
    {
        $this->timestampCedidoAdido = $timestampCedidoAdido;
        return $this;
    }

    /**
     * Get timestampCedidoAdido
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestampCedidoAdido()
    {
        return $this->timestampCedidoAdido;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return AdidoCedidoExcluido
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
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
     * Set PessoalAdidoCedido
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido
     * @return AdidoCedidoExcluido
     */
    public function setFkPessoalAdidoCedido(\Urbem\CoreBundle\Entity\Pessoal\AdidoCedido $fkPessoalAdidoCedido)
    {
        $this->codContrato = $fkPessoalAdidoCedido->getCodContrato();
        $this->codNorma = $fkPessoalAdidoCedido->getCodNorma();
        $this->timestampCedidoAdido = $fkPessoalAdidoCedido->getTimestamp();
        $this->fkPessoalAdidoCedido = $fkPessoalAdidoCedido;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalAdidoCedido
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AdidoCedido
     */
    public function getFkPessoalAdidoCedido()
    {
        return $this->fkPessoalAdidoCedido;
    }
}
