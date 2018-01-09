<?php
 
namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * ValorIndicador
 */
class ValorIndicador
{
    /**
     * PK
     * @var integer
     */
    private $codIndicador;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $inicioVigencia;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico
     */
    private $fkMonetarioIndicadorEconomico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inicioVigencia = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codIndicador
     *
     * @param integer $codIndicador
     * @return ValorIndicador
     */
    public function setCodIndicador($codIndicador)
    {
        $this->codIndicador = $codIndicador;
        return $this;
    }

    /**
     * Get codIndicador
     *
     * @return integer
     */
    public function getCodIndicador()
    {
        return $this->codIndicador;
    }

    /**
     * Set inicioVigencia
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $inicioVigencia
     * @return ValorIndicador
     */
    public function setInicioVigencia(\Urbem\CoreBundle\Helper\DatePK $inicioVigencia)
    {
        $this->inicioVigencia = $inicioVigencia;
        return $this;
    }

    /**
     * Get inicioVigencia
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getInicioVigencia()
    {
        return $this->inicioVigencia;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return ValorIndicador
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioIndicadorEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico $fkMonetarioIndicadorEconomico
     * @return ValorIndicador
     */
    public function setFkMonetarioIndicadorEconomico(\Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico $fkMonetarioIndicadorEconomico)
    {
        $this->codIndicador = $fkMonetarioIndicadorEconomico->getCodIndicador();
        $this->fkMonetarioIndicadorEconomico = $fkMonetarioIndicadorEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioIndicadorEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico
     */
    public function getFkMonetarioIndicadorEconomico()
    {
        return $this->fkMonetarioIndicadorEconomico;
    }
}
