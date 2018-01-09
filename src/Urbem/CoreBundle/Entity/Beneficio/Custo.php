<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * Custo
 */
class Custo
{
    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $inicioVigencia;

    /**
     * PK
     * @var integer
     */
    private $valeTransporteCodValeTransporte;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\ValeTransporte
     */
    private $fkBeneficioValeTransporte;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inicioVigencia = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set inicioVigencia
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $inicioVigencia
     * @return Custo
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
     * Set valeTransporteCodValeTransporte
     *
     * @param integer $valeTransporteCodValeTransporte
     * @return Custo
     */
    public function setValeTransporteCodValeTransporte($valeTransporteCodValeTransporte)
    {
        $this->valeTransporteCodValeTransporte = $valeTransporteCodValeTransporte;
        return $this;
    }

    /**
     * Get valeTransporteCodValeTransporte
     *
     * @return integer
     */
    public function getValeTransporteCodValeTransporte()
    {
        return $this->valeTransporteCodValeTransporte;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return Custo
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
     * Set fkBeneficioValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ValeTransporte $fkBeneficioValeTransporte
     * @return Custo
     */
    public function setFkBeneficioValeTransporte(\Urbem\CoreBundle\Entity\Beneficio\ValeTransporte $fkBeneficioValeTransporte)
    {
        $this->valeTransporteCodValeTransporte = $fkBeneficioValeTransporte->getCodValeTransporte();
        $this->fkBeneficioValeTransporte = $fkBeneficioValeTransporte;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioValeTransporte
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\ValeTransporte
     */
    public function getFkBeneficioValeTransporte()
    {
        return $this->fkBeneficioValeTransporte;
    }
}
