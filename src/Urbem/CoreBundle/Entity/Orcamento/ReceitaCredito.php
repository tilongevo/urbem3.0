<?php
 
namespace Urbem\CoreBundle\Entity\Orcamento;

/**
 * ReceitaCredito
 */
class ReceitaCredito
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
     * @var boolean
     */
    private $dividaAtiva = false;

    /**
     * @var integer
     */
    private $codReceita;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoDesconto
     */
    private $fkOrcamentoReceitaCreditoDescontos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    private $fkMonetarioCredito;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkOrcamentoReceitaCreditoDescontos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ReceitaCredito
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
     * @return ReceitaCredito
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
     * @return ReceitaCredito
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
     * @return ReceitaCredito
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
     * @return ReceitaCredito
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
     * Set dividaAtiva
     *
     * @param boolean $dividaAtiva
     * @return ReceitaCredito
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
     * @return ReceitaCredito
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
     * OneToMany (owning side)
     * Add OrcamentoReceitaCreditoDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoDesconto $fkOrcamentoReceitaCreditoDesconto
     * @return ReceitaCredito
     */
    public function addFkOrcamentoReceitaCreditoDescontos(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoDesconto $fkOrcamentoReceitaCreditoDesconto)
    {
        if (false === $this->fkOrcamentoReceitaCreditoDescontos->contains($fkOrcamentoReceitaCreditoDesconto)) {
            $fkOrcamentoReceitaCreditoDesconto->setFkOrcamentoReceitaCredito($this);
            $this->fkOrcamentoReceitaCreditoDescontos->add($fkOrcamentoReceitaCreditoDesconto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoReceitaCreditoDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoDesconto $fkOrcamentoReceitaCreditoDesconto
     */
    public function removeFkOrcamentoReceitaCreditoDescontos(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoDesconto $fkOrcamentoReceitaCreditoDesconto)
    {
        $this->fkOrcamentoReceitaCreditoDescontos->removeElement($fkOrcamentoReceitaCreditoDesconto);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoReceitaCreditoDescontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoDesconto
     */
    public function getFkOrcamentoReceitaCreditoDescontos()
    {
        return $this->fkOrcamentoReceitaCreditoDescontos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return ReceitaCredito
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

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     * @return ReceitaCredito
     */
    public function setFkMonetarioCredito(\Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito)
    {
        $this->codCredito = $fkMonetarioCredito->getCodCredito();
        $this->codNatureza = $fkMonetarioCredito->getCodNatureza();
        $this->codGenero = $fkMonetarioCredito->getCodGenero();
        $this->codEspecie = $fkMonetarioCredito->getCodEspecie();
        $this->fkMonetarioCredito = $fkMonetarioCredito;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioCredito
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    public function getFkMonetarioCredito()
    {
        return $this->fkMonetarioCredito;
    }
}
