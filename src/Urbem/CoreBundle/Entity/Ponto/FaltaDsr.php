<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * FaltaDsr
 */
class FaltaDsr
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
     * @var \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais
     */
    private $fkPontoConfiguracaoParametrosGerais;

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
     * @return FaltaDsr
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
     * @return FaltaDsr
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
     * @return FaltaDsr
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
     * Set PontoConfiguracaoParametrosGerais
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais
     * @return FaltaDsr
     */
    public function setFkPontoConfiguracaoParametrosGerais(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais)
    {
        $this->codConfiguracao = $fkPontoConfiguracaoParametrosGerais->getCodConfiguracao();
        $this->timestamp = $fkPontoConfiguracaoParametrosGerais->getTimestamp();
        $this->fkPontoConfiguracaoParametrosGerais = $fkPontoConfiguracaoParametrosGerais;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPontoConfiguracaoParametrosGerais
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais
     */
    public function getFkPontoConfiguracaoParametrosGerais()
    {
        return $this->fkPontoConfiguracaoParametrosGerais;
    }
}
