<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * IndicadorEconomico
 */
class IndicadorEconomico
{
    /**
     * PK
     * @var integer
     */
    private $codIndicador;

    /**
     * @var string
     */
    private $abreviatura;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $precisao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador
     */
    private $fkEconomicoAtividadeModalidadeIndicadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador
     */
    private $fkEconomicoCadEconModalidadeIndicadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\FormulaIndicador
     */
    private $fkMonetarioFormulaIndicadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\ValorIndicador
     */
    private $fkMonetarioValorIndicadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoIndicador
     */
    private $fkMonetarioCreditoIndicadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta
     */
    private $fkFiscalizacaoPenalidadeMultas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtividadeModalidadeIndicadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoCadEconModalidadeIndicadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioFormulaIndicadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioValorIndicadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioCreditoIndicadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoPenalidadeMultas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codIndicador
     *
     * @param integer $codIndicador
     * @return IndicadorEconomico
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
     * Set abreviatura
     *
     * @param string $abreviatura
     * @return IndicadorEconomico
     */
    public function setAbreviatura($abreviatura)
    {
        $this->abreviatura = $abreviatura;
        return $this;
    }

    /**
     * Get abreviatura
     *
     * @return string
     */
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return IndicadorEconomico
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set precisao
     *
     * @param integer $precisao
     * @return IndicadorEconomico
     */
    public function setPrecisao($precisao)
    {
        $this->precisao = $precisao;
        return $this;
    }

    /**
     * Get precisao
     *
     * @return integer
     */
    public function getPrecisao()
    {
        return $this->precisao;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtividadeModalidadeIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador $fkEconomicoAtividadeModalidadeIndicador
     * @return IndicadorEconomico
     */
    public function addFkEconomicoAtividadeModalidadeIndicadores(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador $fkEconomicoAtividadeModalidadeIndicador)
    {
        if (false === $this->fkEconomicoAtividadeModalidadeIndicadores->contains($fkEconomicoAtividadeModalidadeIndicador)) {
            $fkEconomicoAtividadeModalidadeIndicador->setFkMonetarioIndicadorEconomico($this);
            $this->fkEconomicoAtividadeModalidadeIndicadores->add($fkEconomicoAtividadeModalidadeIndicador);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtividadeModalidadeIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador $fkEconomicoAtividadeModalidadeIndicador
     */
    public function removeFkEconomicoAtividadeModalidadeIndicadores(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador $fkEconomicoAtividadeModalidadeIndicador)
    {
        $this->fkEconomicoAtividadeModalidadeIndicadores->removeElement($fkEconomicoAtividadeModalidadeIndicador);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtividadeModalidadeIndicadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador
     */
    public function getFkEconomicoAtividadeModalidadeIndicadores()
    {
        return $this->fkEconomicoAtividadeModalidadeIndicadores;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadEconModalidadeIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador $fkEconomicoCadEconModalidadeIndicador
     * @return IndicadorEconomico
     */
    public function addFkEconomicoCadEconModalidadeIndicadores(\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador $fkEconomicoCadEconModalidadeIndicador)
    {
        if (false === $this->fkEconomicoCadEconModalidadeIndicadores->contains($fkEconomicoCadEconModalidadeIndicador)) {
            $fkEconomicoCadEconModalidadeIndicador->setFkMonetarioIndicadorEconomico($this);
            $this->fkEconomicoCadEconModalidadeIndicadores->add($fkEconomicoCadEconModalidadeIndicador);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadEconModalidadeIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador $fkEconomicoCadEconModalidadeIndicador
     */
    public function removeFkEconomicoCadEconModalidadeIndicadores(\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador $fkEconomicoCadEconModalidadeIndicador)
    {
        $this->fkEconomicoCadEconModalidadeIndicadores->removeElement($fkEconomicoCadEconModalidadeIndicador);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadEconModalidadeIndicadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadEconModalidadeIndicador
     */
    public function getFkEconomicoCadEconModalidadeIndicadores()
    {
        return $this->fkEconomicoCadEconModalidadeIndicadores;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioFormulaIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\FormulaIndicador $fkMonetarioFormulaIndicador
     * @return IndicadorEconomico
     */
    public function addFkMonetarioFormulaIndicadores(\Urbem\CoreBundle\Entity\Monetario\FormulaIndicador $fkMonetarioFormulaIndicador)
    {
        if (false === $this->fkMonetarioFormulaIndicadores->contains($fkMonetarioFormulaIndicador)) {
            $fkMonetarioFormulaIndicador->setFkMonetarioIndicadorEconomico($this);
            $this->fkMonetarioFormulaIndicadores->add($fkMonetarioFormulaIndicador);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioFormulaIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\FormulaIndicador $fkMonetarioFormulaIndicador
     */
    public function removeFkMonetarioFormulaIndicadores(\Urbem\CoreBundle\Entity\Monetario\FormulaIndicador $fkMonetarioFormulaIndicador)
    {
        $this->fkMonetarioFormulaIndicadores->removeElement($fkMonetarioFormulaIndicador);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioFormulaIndicadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\FormulaIndicador
     */
    public function getFkMonetarioFormulaIndicadores()
    {
        return $this->fkMonetarioFormulaIndicadores;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioValorIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ValorIndicador $fkMonetarioValorIndicador
     * @return IndicadorEconomico
     */
    public function addFkMonetarioValorIndicadores(\Urbem\CoreBundle\Entity\Monetario\ValorIndicador $fkMonetarioValorIndicador)
    {
        if (false === $this->fkMonetarioValorIndicadores->contains($fkMonetarioValorIndicador)) {
            $fkMonetarioValorIndicador->setFkMonetarioIndicadorEconomico($this);
            $this->fkMonetarioValorIndicadores->add($fkMonetarioValorIndicador);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioValorIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ValorIndicador $fkMonetarioValorIndicador
     */
    public function removeFkMonetarioValorIndicadores(\Urbem\CoreBundle\Entity\Monetario\ValorIndicador $fkMonetarioValorIndicador)
    {
        $this->fkMonetarioValorIndicadores->removeElement($fkMonetarioValorIndicador);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioValorIndicadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\ValorIndicador
     */
    public function getFkMonetarioValorIndicadores()
    {
        return $this->fkMonetarioValorIndicadores;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioCreditoIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoIndicador $fkMonetarioCreditoIndicador
     * @return IndicadorEconomico
     */
    public function addFkMonetarioCreditoIndicadores(\Urbem\CoreBundle\Entity\Monetario\CreditoIndicador $fkMonetarioCreditoIndicador)
    {
        if (false === $this->fkMonetarioCreditoIndicadores->contains($fkMonetarioCreditoIndicador)) {
            $fkMonetarioCreditoIndicador->setFkMonetarioIndicadorEconomico($this);
            $this->fkMonetarioCreditoIndicadores->add($fkMonetarioCreditoIndicador);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioCreditoIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoIndicador $fkMonetarioCreditoIndicador
     */
    public function removeFkMonetarioCreditoIndicadores(\Urbem\CoreBundle\Entity\Monetario\CreditoIndicador $fkMonetarioCreditoIndicador)
    {
        $this->fkMonetarioCreditoIndicadores->removeElement($fkMonetarioCreditoIndicador);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioCreditoIndicadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoIndicador
     */
    public function getFkMonetarioCreditoIndicadores()
    {
        return $this->fkMonetarioCreditoIndicadores;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoPenalidadeMulta
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta
     * @return IndicadorEconomico
     */
    public function addFkFiscalizacaoPenalidadeMultas(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta)
    {
        if (false === $this->fkFiscalizacaoPenalidadeMultas->contains($fkFiscalizacaoPenalidadeMulta)) {
            $fkFiscalizacaoPenalidadeMulta->setFkMonetarioIndicadorEconomico($this);
            $this->fkFiscalizacaoPenalidadeMultas->add($fkFiscalizacaoPenalidadeMulta);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoPenalidadeMulta
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta
     */
    public function removeFkFiscalizacaoPenalidadeMultas(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta)
    {
        $this->fkFiscalizacaoPenalidadeMultas->removeElement($fkFiscalizacaoPenalidadeMulta);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoPenalidadeMultas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta
     */
    public function getFkFiscalizacaoPenalidadeMultas()
    {
        return $this->fkFiscalizacaoPenalidadeMultas;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
