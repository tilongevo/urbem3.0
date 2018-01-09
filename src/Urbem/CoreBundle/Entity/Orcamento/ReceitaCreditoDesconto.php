<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * ReceitaCreditoDesconto
 */
class ReceitaCreditoDesconto
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
    private $codReceita;

    /**
     * PK
     * @var boolean
     */
    private $dividaAtiva = false;

    /**
     * @var string
     */
    private $exercicioDedutora;

    /**
     * @var integer
     */
    private $codReceitaDedutora;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito
     */
    private $fkOrcamentoReceitaCredito;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ReceitaCreditoDesconto
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
     * @return ReceitaCreditoDesconto
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
     * @return ReceitaCreditoDesconto
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
     * @return ReceitaCreditoDesconto
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
     * @return ReceitaCreditoDesconto
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
     * Set codReceita
     *
     * @param integer $codReceita
     * @return ReceitaCreditoDesconto
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
     * Set dividaAtiva
     *
     * @param boolean $dividaAtiva
     * @return ReceitaCreditoDesconto
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
     * Set exercicioDedutora
     *
     * @param string $exercicioDedutora
     * @return ReceitaCreditoDesconto
     */
    public function setExercicioDedutora($exercicioDedutora)
    {
        $this->exercicioDedutora = $exercicioDedutora;
        return $this;
    }

    /**
     * Get exercicioDedutora
     *
     * @return string
     */
    public function getExercicioDedutora()
    {
        return $this->exercicioDedutora;
    }

    /**
     * Set codReceitaDedutora
     *
     * @param integer $codReceitaDedutora
     * @return ReceitaCreditoDesconto
     */
    public function setCodReceitaDedutora($codReceitaDedutora)
    {
        $this->codReceitaDedutora = $codReceitaDedutora;
        return $this;
    }

    /**
     * Get codReceitaDedutora
     *
     * @return integer
     */
    public function getCodReceitaDedutora()
    {
        return $this->codReceitaDedutora;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceitaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito $fkOrcamentoReceitaCredito
     * @return ReceitaCreditoDesconto
     */
    public function setFkOrcamentoReceitaCredito(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito $fkOrcamentoReceitaCredito)
    {
        $this->exercicio = $fkOrcamentoReceitaCredito->getExercicio();
        $this->codEspecie = $fkOrcamentoReceitaCredito->getCodEspecie();
        $this->codGenero = $fkOrcamentoReceitaCredito->getCodGenero();
        $this->codNatureza = $fkOrcamentoReceitaCredito->getCodNatureza();
        $this->codCredito = $fkOrcamentoReceitaCredito->getCodCredito();
        $this->dividaAtiva = $fkOrcamentoReceitaCredito->getDividaAtiva();
        $this->fkOrcamentoReceitaCredito = $fkOrcamentoReceitaCredito;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoReceitaCredito
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito
     */
    public function getFkOrcamentoReceitaCredito()
    {
        return $this->fkOrcamentoReceitaCredito;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return ReceitaCreditoDesconto
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicioDedutora = $fkOrcamentoReceita->getExercicio();
        $this->codReceitaDedutora = $fkOrcamentoReceita->getCodReceita();
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
