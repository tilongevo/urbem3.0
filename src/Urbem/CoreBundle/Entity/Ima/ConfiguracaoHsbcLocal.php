<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoHsbcLocal
 */
class ConfiguracaoHsbcLocal
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
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codLocal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta
     */
    private $fkImaConfiguracaoHsbcConta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConfiguracaoHsbcLocal
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
     * @return ConfiguracaoHsbcLocal
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
     * @return ConfiguracaoHsbcLocal
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
     * @return ConfiguracaoHsbcLocal
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
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ConfiguracaoHsbcLocal
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
     * Set codLocal
     *
     * @param integer $codLocal
     * @return ConfiguracaoHsbcLocal
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaConfiguracaoHsbcConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta $fkImaConfiguracaoHsbcConta
     * @return ConfiguracaoHsbcLocal
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
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return ConfiguracaoHsbcLocal
     */
    public function setFkOrganogramaLocal(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->codLocal = $fkOrganogramaLocal->getCodLocal();
        $this->fkOrganogramaLocal = $fkOrganogramaLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocal()
    {
        return $this->fkOrganogramaLocal;
    }
}
