<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * PlanoAnaliticaCreditoAcrescimo
 */
class PlanoAnaliticaCreditoAcrescimo
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEspecie;

    /**
     * PK
     * @var integer
     */
    private $codGenero;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codCredito;

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
     * @var integer
     */
    private $codPlano;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo
     */
    private $fkMonetarioCreditoAcrescimo;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PlanoAnaliticaCreditoAcrescimo
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return PlanoAnaliticaCreditoAcrescimo
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set codGenero
     *
     * @param integer $codGenero
     * @return PlanoAnaliticaCreditoAcrescimo
     */
    public function setCodGenero($codGenero)
    {
        $this->codGenero = $codGenero;
        return $this;
    }

    /**
     * Get codGenero
     *
     * @return integer
     */
    public function getCodGenero()
    {
        return $this->codGenero;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return PlanoAnaliticaCreditoAcrescimo
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set codCredito
     *
     * @param integer $codCredito
     * @return PlanoAnaliticaCreditoAcrescimo
     */
    public function setCodCredito($codCredito)
    {
        $this->codCredito = $codCredito;
        return $this;
    }

    /**
     * Get codCredito
     *
     * @return integer
     */
    public function getCodCredito()
    {
        return $this->codCredito;
    }

    /**
     * Set codAcrescimo
     *
     * @param integer $codAcrescimo
     * @return PlanoAnaliticaCreditoAcrescimo
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
     * @return PlanoAnaliticaCreditoAcrescimo
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
     * Set codPlano
     *
     * @param integer $codPlano
     * @return PlanoAnaliticaCreditoAcrescimo
     */
    public function setCodPlano($codPlano = null)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return PlanoAnaliticaCreditoAcrescimo
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo $fkMonetarioCreditoAcrescimo
     * @return PlanoAnaliticaCreditoAcrescimo
     */
    public function setFkMonetarioCreditoAcrescimo(\Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo $fkMonetarioCreditoAcrescimo)
    {
        $this->codEspecie = $fkMonetarioCreditoAcrescimo->getCodEspecie();
        $this->codGenero = $fkMonetarioCreditoAcrescimo->getCodGenero();
        $this->codNatureza = $fkMonetarioCreditoAcrescimo->getCodNatureza();
        $this->codCredito = $fkMonetarioCreditoAcrescimo->getCodCredito();
        $this->codAcrescimo = $fkMonetarioCreditoAcrescimo->getCodAcrescimo();
        $this->codTipo = $fkMonetarioCreditoAcrescimo->getCodTipo();
        $this->fkMonetarioCreditoAcrescimo = $fkMonetarioCreditoAcrescimo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioCreditoAcrescimo
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo
     */
    public function getFkMonetarioCreditoAcrescimo()
    {
        return $this->fkMonetarioCreditoAcrescimo;
    }
}
