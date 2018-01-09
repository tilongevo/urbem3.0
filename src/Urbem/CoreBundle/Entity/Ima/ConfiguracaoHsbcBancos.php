<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoHsbcBancos
 */
class ConfiguracaoHsbcBancos
{
    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * PK
     * @var integer
     */
    private $codBanco;

    /**
     * PK
     * @var integer
     */
    private $codAgencia;

    /**
     * PK
     * @var integer
     */
    private $codContaCorrente;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codBancoOutros;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta
     */
    private $fkImaConfiguracaoHsbcConta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Banco
     */
    private $fkMonetarioBanco;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConfiguracaoHsbcBancos
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
     * Set codBanco
     *
     * @param integer $codBanco
     * @return ConfiguracaoHsbcBancos
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return ConfiguracaoHsbcBancos
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codContaCorrente
     *
     * @param integer $codContaCorrente
     * @return ConfiguracaoHsbcBancos
     */
    public function setCodContaCorrente($codContaCorrente)
    {
        $this->codContaCorrente = $codContaCorrente;
        return $this;
    }

    /**
     * Get codContaCorrente
     *
     * @return integer
     */
    public function getCodContaCorrente()
    {
        return $this->codContaCorrente;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoHsbcBancos
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
     * Set codBancoOutros
     *
     * @param integer $codBancoOutros
     * @return ConfiguracaoHsbcBancos
     */
    public function setCodBancoOutros($codBancoOutros)
    {
        $this->codBancoOutros = $codBancoOutros;
        return $this;
    }

    /**
     * Get codBancoOutros
     *
     * @return integer
     */
    public function getCodBancoOutros()
    {
        return $this->codBancoOutros;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoHsbcConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta $fkImaConfiguracaoHsbcConta
     * @return ConfiguracaoHsbcBancos
     */
    public function setFkImaConfiguracaoHsbcConta(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta $fkImaConfiguracaoHsbcConta)
    {
        $this->codConvenio = $fkImaConfiguracaoHsbcConta->getCodConvenio();
        $this->codBanco = $fkImaConfiguracaoHsbcConta->getCodBanco();
        $this->codAgencia = $fkImaConfiguracaoHsbcConta->getCodAgencia();
        $this->codContaCorrente = $fkImaConfiguracaoHsbcConta->getCodContaCorrente();
        $this->timestamp = $fkImaConfiguracaoHsbcConta->getTimestamp();
        $this->fkImaConfiguracaoHsbcConta = $fkImaConfiguracaoHsbcConta;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaConfiguracaoHsbcConta
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta
     */
    public function getFkImaConfiguracaoHsbcConta()
    {
        return $this->fkImaConfiguracaoHsbcConta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioBanco
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Banco $fkMonetarioBanco
     * @return ConfiguracaoHsbcBancos
     */
    public function setFkMonetarioBanco(\Urbem\CoreBundle\Entity\Monetario\Banco $fkMonetarioBanco)
    {
        $this->codBancoOutros = $fkMonetarioBanco->getCodBanco();
        $this->fkMonetarioBanco = $fkMonetarioBanco;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioBanco
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Banco
     */
    public function getFkMonetarioBanco()
    {
        return $this->fkMonetarioBanco;
    }
}
