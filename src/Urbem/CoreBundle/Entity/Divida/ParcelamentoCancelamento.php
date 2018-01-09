<?php

namespace Urbem\CoreBundle\Entity\Divida;

/**
 * ParcelamentoCancelamento
 */
class ParcelamentoCancelamento
{
    /**
     * PK
     * @var integer
     */
    private $numParcelamento;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    private $fkDividaParcelamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set numParcelamento
     *
     * @param integer $numParcelamento
     * @return ParcelamentoCancelamento
     */
    public function setNumParcelamento($numParcelamento)
    {
        $this->numParcelamento = $numParcelamento;
        return $this;
    }

    /**
     * Get numParcelamento
     *
     * @return integer
     */
    public function getNumParcelamento()
    {
        return $this->numParcelamento;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ParcelamentoCancelamento
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return ParcelamentoCancelamento
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ParcelamentoCancelamento
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
     * OneToOne (owning side)
     * Set DividaParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento
     * @return ParcelamentoCancelamento
     */
    public function setFkDividaParcelamento(\Urbem\CoreBundle\Entity\Divida\Parcelamento $fkDividaParcelamento)
    {
        $this->numParcelamento = $fkDividaParcelamento->getNumParcelamento();
        $this->fkDividaParcelamento = $fkDividaParcelamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkDividaParcelamento
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Parcelamento
     */
    public function getFkDividaParcelamento()
    {
        return $this->fkDividaParcelamento;
    }
}
