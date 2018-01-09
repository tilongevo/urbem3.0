<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * ReceitaCreditoAcrescimo
 */
class ReceitaCreditoAcrescimo
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codAcrescimo;

    /**
     * PK
     * @var integer
     */
    private $codCredito;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codGenero;

    /**
     * PK
     * @var integer
     */
    private $codEspecie;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var boolean
     */
    private $dividaAtiva = false;

    /**
     * @var integer
     */
    private $codReceita;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo
     */
    private $fkMonetarioCreditoAcrescimo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;


    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ReceitaCreditoAcrescimo
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
     * Set codAcrescimo
     *
     * @param integer $codAcrescimo
     * @return ReceitaCreditoAcrescimo
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
     * Set codCredito
     *
     * @param integer $codCredito
     * @return ReceitaCreditoAcrescimo
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
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return ReceitaCreditoAcrescimo
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
     * Set codGenero
     *
     * @param integer $codGenero
     * @return ReceitaCreditoAcrescimo
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
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return ReceitaCreditoAcrescimo
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ReceitaCreditoAcrescimo
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
     * Set dividaAtiva
     *
     * @param boolean $dividaAtiva
     * @return ReceitaCreditoAcrescimo
     */
    public function setDividaAtiva($dividaAtiva)
    {
        $this->dividaAtiva = $dividaAtiva;
        return $this;
    }

    /**
     * Get dividaAtiva
     *
     * @return boolean
     */
    public function getDividaAtiva()
    {
        return $this->dividaAtiva;
    }

    /**
     * Set codReceita
     *
     * @param integer $codReceita
     * @return ReceitaCreditoAcrescimo
     */
    public function setCodReceita($codReceita)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo $fkMonetarioCreditoAcrescimo
     * @return ReceitaCreditoAcrescimo
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

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return ReceitaCreditoAcrescimo
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicio = $fkOrcamentoReceita->getExercicio();
        $this->codReceita = $fkOrcamentoReceita->getCodReceita();
        $this->fkOrcamentoReceita = $fkOrcamentoReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceita()
    {
        return $this->fkOrcamentoReceita;
    }
}
