<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoConvenioCaixaEconomicaFederal
 */
class ConfiguracaoConvenioCaixaEconomicaFederal
{
    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * @var string
     */
    private $codConvenioBanco;

    /**
     * @var integer
     */
    private $codBanco;

    /**
     * @var integer
     */
    private $codAgencia;

    /**
     * @var integer
     */
    private $codContaCorrente;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    private $fkMonetarioContaCorrente;


    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConfiguracaoConvenioCaixaEconomicaFederal
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
     * Set codConvenioBanco
     *
     * @param string $codConvenioBanco
     * @return ConfiguracaoConvenioCaixaEconomicaFederal
     */
    public function setCodConvenioBanco($codConvenioBanco)
    {
        $this->codConvenioBanco = $codConvenioBanco;
        return $this;
    }

    /**
     * Get codConvenioBanco
     *
     * @return string
     */
    public function getCodConvenioBanco()
    {
        return $this->codConvenioBanco;
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return ConfiguracaoConvenioCaixaEconomicaFederal
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
     * @return ConfiguracaoConvenioCaixaEconomicaFederal
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
     * @return ConfiguracaoConvenioCaixaEconomicaFederal
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ConfiguracaoConvenioCaixaEconomicaFederal
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     * @return ConfiguracaoConvenioCaixaEconomicaFederal
     */
    public function setFkMonetarioContaCorrente(\Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente)
    {
        $this->codBanco = $fkMonetarioContaCorrente->getCodBanco();
        $this->codAgencia = $fkMonetarioContaCorrente->getCodAgencia();
        $this->codContaCorrente = $fkMonetarioContaCorrente->getCodContaCorrente();
        $this->fkMonetarioContaCorrente = $fkMonetarioContaCorrente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioContaCorrente
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    public function getFkMonetarioContaCorrente()
    {
        return $this->fkMonetarioContaCorrente;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codConvenio;
    }
}
