<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * DepreciacaoAnulada
 */
class DepreciacaoAnulada
{
    /**
     * PK
     * @var integer
     */
    private $codDepreciacao;

    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $timestampAnulacao;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Depreciacao
     */
    private $fkPatrimonioDepreciacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
        $this->timestampAnulacao = new \DateTime;
    }

    /**
     * Set codDepreciacao
     *
     * @param integer $codDepreciacao
     * @return DepreciacaoAnulada
     */
    public function setCodDepreciacao($codDepreciacao)
    {
        $this->codDepreciacao = $codDepreciacao;
        return $this;
    }

    /**
     * Get codDepreciacao
     *
     * @return integer
     */
    public function getCodDepreciacao()
    {
        return $this->codDepreciacao;
    }

    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return DepreciacaoAnulada
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return DepreciacaoAnulada
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set timestampAnulacao
     *
     * @param \DateTime $timestampAnulacao
     * @return DepreciacaoAnulada
     */
    public function setTimestampAnulacao(\DateTime $timestampAnulacao)
    {
        $this->timestampAnulacao = $timestampAnulacao;
        return $this;
    }

    /**
     * Get timestampAnulacao
     *
     * @return \DateTime
     */
    public function getTimestampAnulacao()
    {
        return $this->timestampAnulacao;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return DepreciacaoAnulada
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
     * Set PatrimonioDepreciacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Depreciacao $fkPatrimonioDepreciacao
     * @return DepreciacaoAnulada
     */
    public function setFkPatrimonioDepreciacao(\Urbem\CoreBundle\Entity\Patrimonio\Depreciacao $fkPatrimonioDepreciacao)
    {
        $this->codDepreciacao = $fkPatrimonioDepreciacao->getCodDepreciacao();
        $this->codBem = $fkPatrimonioDepreciacao->getCodBem();
        $this->timestamp = $fkPatrimonioDepreciacao->getTimestamp();
        $this->fkPatrimonioDepreciacao = $fkPatrimonioDepreciacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPatrimonioDepreciacao
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Depreciacao
     */
    public function getFkPatrimonioDepreciacao()
    {
        return $this->fkPatrimonioDepreciacao;
    }
}
