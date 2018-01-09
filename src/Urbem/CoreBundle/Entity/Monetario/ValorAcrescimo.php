<?php
 
namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * ValorAcrescimo
 */
class ValorAcrescimo
{
    /**
     * PK
     * @var integer
     */
    private $codAcrescimo;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

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
     * @var \Urbem\CoreBundle\Entity\Monetario\Acrescimo
     */
    private $fkMonetarioAcrescimo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inicioVigencia = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codAcrescimo
     *
     * @param integer $codAcrescimo
     * @return ValorAcrescimo
     */
    public function setCodAcrescimo($codAcrescimo)
    {
        $this->codAcrescimo = $codAcrescimo;
        return $this;
    }

    /**
     * Get codAcrescimo
     *
     * @return integer
     */
    public function getCodAcrescimo()
    {
        return $this->codAcrescimo;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ValorAcrescimo
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
     * Set inicioVigencia
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $inicioVigencia
     * @return ValorAcrescimo
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
     * @return ValorAcrescimo
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
     * Set fkMonetarioAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo
     * @return ValorAcrescimo
     */
    public function setFkMonetarioAcrescimo(\Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo)
    {
        $this->codAcrescimo = $fkMonetarioAcrescimo->getCodAcrescimo();
        $this->codTipo = $fkMonetarioAcrescimo->getCodTipo();
        $this->fkMonetarioAcrescimo = $fkMonetarioAcrescimo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioAcrescimo
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Acrescimo
     */
    public function getFkMonetarioAcrescimo()
    {
        return $this->fkMonetarioAcrescimo;
    }
}
