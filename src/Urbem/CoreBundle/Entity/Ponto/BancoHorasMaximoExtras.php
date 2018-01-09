<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * BancoHorasMaximoExtras
 */
class BancoHorasMaximoExtras
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $horas;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras
     */
    private $fkPontoConfiguracaoBancoHoras;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return BancoHorasMaximoExtras
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return BancoHorasMaximoExtras
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
     * Set horas
     *
     * @param \DateTime $horas
     * @return BancoHorasMaximoExtras
     */
    public function setHoras(\DateTime $horas)
    {
        $this->horas = $horas;
        return $this;
    }

    /**
     * Get horas
     *
     * @return \DateTime
     */
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * OneToOne (owning side)
     * Set PontoConfiguracaoBancoHoras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras $fkPontoConfiguracaoBancoHoras
     * @return BancoHorasMaximoExtras
     */
    public function setFkPontoConfiguracaoBancoHoras(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras $fkPontoConfiguracaoBancoHoras)
    {
        $this->codConfiguracao = $fkPontoConfiguracaoBancoHoras->getCodConfiguracao();
        $this->timestamp = $fkPontoConfiguracaoBancoHoras->getTimestamp();
        $this->fkPontoConfiguracaoBancoHoras = $fkPontoConfiguracaoBancoHoras;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPontoConfiguracaoBancoHoras
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras
     */
    public function getFkPontoConfiguracaoBancoHoras()
    {
        return $this->fkPontoConfiguracaoBancoHoras;
    }
}
