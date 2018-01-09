<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * ArrecadacaoCarneEstornado
 */
class ArrecadacaoCarneEstornado
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var string
     */
    private $numeracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampArrecadacao;

    /**
     * PK
     * @var integer
     */
    private $codArrecadacao;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne
     */
    private $fkTesourariaArrecadacaoCarne;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampArrecadacao = new DateTimeMicrosecondPK();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ArrecadacaoCarneEstornado
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
     * Set numeracao
     *
     * @param string $numeracao
     * @return ArrecadacaoCarneEstornado
     */
    public function setNumeracao($numeracao)
    {
        $this->numeracao = $numeracao;
        return $this;
    }

    /**
     * Get numeracao
     *
     * @return string
     */
    public function getNumeracao()
    {
        return $this->numeracao;
    }

    /**
     * Set timestampArrecadacao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestampArrecadacao
     * @return ArrecadacaoCarneEstornado
     */
    public function setTimestampArrecadacao(\Urbem\CoreBundle\Helper\DateTimePK $timestampArrecadacao)
    {
        $this->timestampArrecadacao = $timestampArrecadacao;
        return $this;
    }

    /**
     * Get timestampArrecadacao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestampArrecadacao()
    {
        return $this->timestampArrecadacao;
    }

    /**
     * Set codArrecadacao
     *
     * @param integer $codArrecadacao
     * @return ArrecadacaoCarneEstornado
     */
    public function setCodArrecadacao($codArrecadacao)
    {
        $this->codArrecadacao = $codArrecadacao;
        return $this;
    }

    /**
     * Get codArrecadacao
     *
     * @return integer
     */
    public function getCodArrecadacao()
    {
        return $this->codArrecadacao;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ArrecadacaoCarneEstornado
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return ArrecadacaoCarneEstornado
     */
    public function setTimestamp(\DateTime $timestamp)
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
     * Set TesourariaArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne $fkTesourariaArrecadacaoCarne
     * @return ArrecadacaoCarneEstornado
     */
    public function setFkTesourariaArrecadacaoCarne(\Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne $fkTesourariaArrecadacaoCarne)
    {
        $this->codArrecadacao = $fkTesourariaArrecadacaoCarne->getCodArrecadacao();
        $this->timestampArrecadacao = $fkTesourariaArrecadacaoCarne->getTimestampArrecadacao();
        $this->numeracao = $fkTesourariaArrecadacaoCarne->getNumeracao();
        $this->exercicio = $fkTesourariaArrecadacaoCarne->getExercicio();
        $this->codConvenio = $fkTesourariaArrecadacaoCarne->getCodConvenio();
        $this->fkTesourariaArrecadacaoCarne = $fkTesourariaArrecadacaoCarne;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkTesourariaArrecadacaoCarne
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoCarne
     */
    public function getFkTesourariaArrecadacaoCarne()
    {
        return $this->fkTesourariaArrecadacaoCarne;
    }
}
