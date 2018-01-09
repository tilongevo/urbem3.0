<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * HorasExtras
 */
class HorasExtras
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
     * @var integer
     */
    private $minutos;

    /**
     * @var string
     */
    private $periodo;

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
     * @return HorasExtras
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
     * @return HorasExtras
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
     * Set minutos
     *
     * @param integer $minutos
     * @return HorasExtras
     */
    public function setMinutos($minutos)
    {
        $this->minutos = $minutos;
        return $this;
    }

    /**
     * Get minutos
     *
     * @return integer
     */
    public function getMinutos()
    {
        return $this->minutos;
    }

    /**
     * Set periodo
     *
     * @param string $periodo
     * @return HorasExtras
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
        return $this;
    }

    /**
     * Get periodo
     *
     * @return string
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * OneToOne (owning side)
     * Set PontoConfiguracaoParametrosGerais
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais
     * @return HorasExtras
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
