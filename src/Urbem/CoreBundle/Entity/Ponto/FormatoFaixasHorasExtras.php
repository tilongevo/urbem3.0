<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * FormatoFaixasHorasExtras
 */
class FormatoFaixasHorasExtras
{
    /**
     * PK
     * @var integer
     */
    private $codFormato;

    /**
     * PK
     * @var integer
     */
    private $codDado;

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
     * PK
     * @var integer
     */
    private $codFaixa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\DadosExportacao
     */
    private $fkPontoDadosExportacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra
     */
    private $fkPontoFaixasHorasExtra;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codFormato
     *
     * @param integer $codFormato
     * @return FormatoFaixasHorasExtras
     */
    public function setCodFormato($codFormato)
    {
        $this->codFormato = $codFormato;
        return $this;
    }

    /**
     * Get codFormato
     *
     * @return integer
     */
    public function getCodFormato()
    {
        return $this->codFormato;
    }

    /**
     * Set codDado
     *
     * @param integer $codDado
     * @return FormatoFaixasHorasExtras
     */
    public function setCodDado($codDado)
    {
        $this->codDado = $codDado;
        return $this;
    }

    /**
     * Get codDado
     *
     * @return integer
     */
    public function getCodDado()
    {
        return $this->codDado;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return FormatoFaixasHorasExtras
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
     * @return FormatoFaixasHorasExtras
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
     * Set codFaixa
     *
     * @param integer $codFaixa
     * @return FormatoFaixasHorasExtras
     */
    public function setCodFaixa($codFaixa)
    {
        $this->codFaixa = $codFaixa;
        return $this;
    }

    /**
     * Get codFaixa
     *
     * @return integer
     */
    public function getCodFaixa()
    {
        return $this->codFaixa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoDadosExportacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao
     * @return FormatoFaixasHorasExtras
     */
    public function setFkPontoDadosExportacao(\Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao)
    {
        $this->codFormato = $fkPontoDadosExportacao->getCodFormato();
        $this->codDado = $fkPontoDadosExportacao->getCodDado();
        $this->fkPontoDadosExportacao = $fkPontoDadosExportacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoDadosExportacao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\DadosExportacao
     */
    public function getFkPontoDadosExportacao()
    {
        return $this->fkPontoDadosExportacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoFaixasHorasExtra
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra $fkPontoFaixasHorasExtra
     * @return FormatoFaixasHorasExtras
     */
    public function setFkPontoFaixasHorasExtra(\Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra $fkPontoFaixasHorasExtra)
    {
        $this->codConfiguracao = $fkPontoFaixasHorasExtra->getCodConfiguracao();
        $this->timestamp = $fkPontoFaixasHorasExtra->getTimestamp();
        $this->codFaixa = $fkPontoFaixasHorasExtra->getCodFaixa();
        $this->fkPontoFaixasHorasExtra = $fkPontoFaixasHorasExtra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoFaixasHorasExtra
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra
     */
    public function getFkPontoFaixasHorasExtra()
    {
        return $this->fkPontoFaixasHorasExtra;
    }
}
