<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * AposentadoriaEncerramento
 */
class AposentadoriaEncerramento
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var \DateTime
     */
    private $dtEncerramento;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
        $this->dtEncerramento = new \DateTime;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AposentadoriaEncerramento
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
     * Set codContrato
     *
     * @param integer $codContrato
     * @return AposentadoriaEncerramento
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
     * Set motivo
     *
     * @param string $motivo
     * @return AposentadoriaEncerramento
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
     * Set dtEncerramento
     *
     * @param \DateTime $dtEncerramento
     * @return AposentadoriaEncerramento
     */
    public function setDtEncerramento(\DateTime $dtEncerramento)
    {
        $this->dtEncerramento = $dtEncerramento;
        return $this;
    }

    /**
     * Get dtEncerramento
     *
     * @return \DateTime
     */
    public function getDtEncerramento()
    {
        return $this->dtEncerramento;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalAposentadoria
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Aposentadoria $fkPessoalAposentadoria
     * @return AposentadoriaEncerramento
     */
    public function setFkPessoalAposentadoria(\Urbem\CoreBundle\Entity\Pessoal\Aposentadoria $fkPessoalAposentadoria)
    {
        $this->codContrato = $fkPessoalAposentadoria->getCodContrato();
        $this->timestamp = $fkPessoalAposentadoria->getTimestamp();
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
