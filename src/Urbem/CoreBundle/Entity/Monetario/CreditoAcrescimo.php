<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * CreditoAcrescimo
 */
class CreditoAcrescimo
{
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
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCreditoAcrescimo
     */
    private $fkContabilidadePlanoAnaliticaCreditoAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoAcrescimo
     */
    private $fkOrcamentoReceitaCreditoAcrescimos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    private $fkMonetarioCredito;

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
        $this->fkContabilidadePlanoAnaliticaCreditoAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoReceitaCreditoAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return CreditoAcrescimo
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
     * @return CreditoAcrescimo
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
     * @return CreditoAcrescimo
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
     * @return CreditoAcrescimo
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
     * @return CreditoAcrescimo
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
     * @return CreditoAcrescimo
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
     * OneToMany (owning side)
     * Add ContabilidadePlanoAnaliticaCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCreditoAcrescimo $fkContabilidadePlanoAnaliticaCreditoAcrescimo
     * @return CreditoAcrescimo
     */
    public function addFkContabilidadePlanoAnaliticaCreditoAcrescimos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCreditoAcrescimo $fkContabilidadePlanoAnaliticaCreditoAcrescimo)
    {
        if (false === $this->fkContabilidadePlanoAnaliticaCreditoAcrescimos->contains($fkContabilidadePlanoAnaliticaCreditoAcrescimo)) {
            $fkContabilidadePlanoAnaliticaCreditoAcrescimo->setFkMonetarioCreditoAcrescimo($this);
            $this->fkContabilidadePlanoAnaliticaCreditoAcrescimos->add($fkContabilidadePlanoAnaliticaCreditoAcrescimo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoAnaliticaCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCreditoAcrescimo $fkContabilidadePlanoAnaliticaCreditoAcrescimo
     */
    public function removeFkContabilidadePlanoAnaliticaCreditoAcrescimos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCreditoAcrescimo $fkContabilidadePlanoAnaliticaCreditoAcrescimo)
    {
        $this->fkContabilidadePlanoAnaliticaCreditoAcrescimos->removeElement($fkContabilidadePlanoAnaliticaCreditoAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoAnaliticaCreditoAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCreditoAcrescimo
     */
    public function getFkContabilidadePlanoAnaliticaCreditoAcrescimos()
    {
        return $this->fkContabilidadePlanoAnaliticaCreditoAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoReceitaCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoAcrescimo $fkOrcamentoReceitaCreditoAcrescimo
     * @return CreditoAcrescimo
     */
    public function addFkOrcamentoReceitaCreditoAcrescimos(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoAcrescimo $fkOrcamentoReceitaCreditoAcrescimo)
    {
        if (false === $this->fkOrcamentoReceitaCreditoAcrescimos->contains($fkOrcamentoReceitaCreditoAcrescimo)) {
            $fkOrcamentoReceitaCreditoAcrescimo->setFkMonetarioCreditoAcrescimo($this);
            $this->fkOrcamentoReceitaCreditoAcrescimos->add($fkOrcamentoReceitaCreditoAcrescimo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoReceitaCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoAcrescimo $fkOrcamentoReceitaCreditoAcrescimo
     */
    public function removeFkOrcamentoReceitaCreditoAcrescimos(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoAcrescimo $fkOrcamentoReceitaCreditoAcrescimo)
    {
        $this->fkOrcamentoReceitaCreditoAcrescimos->removeElement($fkOrcamentoReceitaCreditoAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoReceitaCreditoAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCreditoAcrescimo
     */
    public function getFkOrcamentoReceitaCreditoAcrescimos()
    {
        return $this->fkOrcamentoReceitaCreditoAcrescimos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     * @return CreditoAcrescimo
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

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo
     * @return CreditoAcrescimo
     */
    public function setFkMonetarioAcrescimo(\Urbem\CoreBundle\Entity\Monetario\Acrescimo $fkMonetarioAcrescimo = null)
    {
        if (!$fkMonetarioAcrescimo) {
            return $this;
        }

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

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->getFkMonetarioAcrescimo()->getDescricaoAcrescimo();
    }
}
