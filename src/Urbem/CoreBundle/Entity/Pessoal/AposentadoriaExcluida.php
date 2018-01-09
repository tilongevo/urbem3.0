<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AposentadoriaExcluida
 */
class AposentadoriaExcluida
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestampAposentadoria;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Aposentadoria
     */
    private $fkPessoalAposentadoria;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampAposentadoria = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return AposentadoriaExcluida
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
     * Set timestampAposentadoria
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAposentadoria
     * @return AposentadoriaExcluida
     */
    public function setTimestampAposentadoria(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampAposentadoria)
    {
        $this->timestampAposentadoria = $timestampAposentadoria;
        return $this;
    }

    /**
     * Get timestampAposentadoria
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampAposentadoria()
    {
        return $this->timestampAposentadoria;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AposentadoriaExcluida
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
     * Set PessoalAposentadoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Aposentadoria $fkPessoalAposentadoria
     * @return AposentadoriaExcluida
     */
    public function setFkPessoalAposentadoria(\Urbem\CoreBundle\Entity\Pessoal\Aposentadoria $fkPessoalAposentadoria)
    {
        $this->codContrato = $fkPessoalAposentadoria->getCodContrato();
        $this->timestampAposentadoria = $fkPessoalAposentadoria->getTimestamp();
        $this->fkPessoalAposentadoria = $fkPessoalAposentadoria;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalAposentadoria
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Aposentadoria
     */
    public function getFkPessoalAposentadoria()
    {
        return $this->fkPessoalAposentadoria;
    }
}
