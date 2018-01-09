<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * Acrescimo
 */
class Acrescimo
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
     * @var string
     */
    private $descricaoAcrescimo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AcrescimoGrupo
     */
    private $fkArrecadacaoAcrescimoGrupos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo
     */
    private $fkArrecadacaoPagamentoAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaAcrescimo
     */
    private $fkDividaDividaAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaAcrescimo
     */
    private $fkDividaParcelaAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoAcrescimo
     */
    private $fkFiscalizacaoLevantamentoAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma
     */
    private $fkMonetarioAcrescimoNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\ValorAcrescimo
     */
    private $fkMonetarioValorAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo
     */
    private $fkMonetarioFormulaAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo
     */
    private $fkMonetarioCreditoAcrescimos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\TipoAcrescimo
     */
    private $fkMonetarioTipoAcrescimo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoAcrescimoGrupos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaParcelaAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoLevantamentoAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioAcrescimoNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioValorAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioFormulaAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioCreditoAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAcrescimo
     *
     * @param integer $codAcrescimo
     * @return Acrescimo
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
     * @return Acrescimo
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
     * Set descricaoAcrescimo
     *
     * @param string $descricaoAcrescimo
     * @return Acrescimo
     */
    public function setDescricaoAcrescimo($descricaoAcrescimo)
    {
        $this->descricaoAcrescimo = $descricaoAcrescimo;
        return $this;
    }

    /**
     * Get descricaoAcrescimo
     *
     * @return string
     */
    public function getDescricaoAcrescimo()
    {
        return $this->descricaoAcrescimo;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAcrescimoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AcrescimoGrupo $fkArrecadacaoAcrescimoGrupo
     * @return Acrescimo
     */
    public function addFkArrecadacaoAcrescimoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\AcrescimoGrupo $fkArrecadacaoAcrescimoGrupo)
    {
        if (false === $this->fkArrecadacaoAcrescimoGrupos->contains($fkArrecadacaoAcrescimoGrupo)) {
            $fkArrecadacaoAcrescimoGrupo->setFkMonetarioAcrescimo($this);
            $this->fkArrecadacaoAcrescimoGrupos->add($fkArrecadacaoAcrescimoGrupo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAcrescimoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AcrescimoGrupo $fkArrecadacaoAcrescimoGrupo
     */
    public function removeFkArrecadacaoAcrescimoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\AcrescimoGrupo $fkArrecadacaoAcrescimoGrupo)
    {
        $this->fkArrecadacaoAcrescimoGrupos->removeElement($fkArrecadacaoAcrescimoGrupo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAcrescimoGrupos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AcrescimoGrupo
     */
    public function getFkArrecadacaoAcrescimoGrupos()
    {
        return $this->fkArrecadacaoAcrescimoGrupos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo $fkArrecadacaoPagamentoAcrescimo
     * @return Acrescimo
     */
    public function addFkArrecadacaoPagamentoAcrescimos(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo $fkArrecadacaoPagamentoAcrescimo)
    {
        if (false === $this->fkArrecadacaoPagamentoAcrescimos->contains($fkArrecadacaoPagamentoAcrescimo)) {
            $fkArrecadacaoPagamentoAcrescimo->setFkMonetarioAcrescimo($this);
            $this->fkArrecadacaoPagamentoAcrescimos->add($fkArrecadacaoPagamentoAcrescimo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamentoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo $fkArrecadacaoPagamentoAcrescimo
     */
    public function removeFkArrecadacaoPagamentoAcrescimos(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo $fkArrecadacaoPagamentoAcrescimo)
    {
        $this->fkArrecadacaoPagamentoAcrescimos->removeElement($fkArrecadacaoPagamentoAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentoAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoAcrescimo
     */
    public function getFkArrecadacaoPagamentoAcrescimos()
    {
        return $this->fkArrecadacaoPagamentoAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAcrescimo $fkDividaDividaAcrescimo
     * @return Acrescimo
     */
    public function addFkDividaDividaAcrescimos(\Urbem\CoreBundle\Entity\Divida\DividaAcrescimo $fkDividaDividaAcrescimo)
    {
        if (false === $this->fkDividaDividaAcrescimos->contains($fkDividaDividaAcrescimo)) {
            $fkDividaDividaAcrescimo->setFkMonetarioAcrescimo($this);
            $this->fkDividaDividaAcrescimos->add($fkDividaDividaAcrescimo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAcrescimo $fkDividaDividaAcrescimo
     */
    public function removeFkDividaDividaAcrescimos(\Urbem\CoreBundle\Entity\Divida\DividaAcrescimo $fkDividaDividaAcrescimo)
    {
        $this->fkDividaDividaAcrescimos->removeElement($fkDividaDividaAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaAcrescimo
     */
    public function getFkDividaDividaAcrescimos()
    {
        return $this->fkDividaDividaAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaParcelaAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaAcrescimo $fkDividaParcelaAcrescimo
     * @return Acrescimo
     */
    public function addFkDividaParcelaAcrescimos(\Urbem\CoreBundle\Entity\Divida\ParcelaAcrescimo $fkDividaParcelaAcrescimo)
    {
        if (false === $this->fkDividaParcelaAcrescimos->contains($fkDividaParcelaAcrescimo)) {
            $fkDividaParcelaAcrescimo->setFkMonetarioAcrescimo($this);
            $this->fkDividaParcelaAcrescimos->add($fkDividaParcelaAcrescimo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaParcelaAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaAcrescimo $fkDividaParcelaAcrescimo
     */
    public function removeFkDividaParcelaAcrescimos(\Urbem\CoreBundle\Entity\Divida\ParcelaAcrescimo $fkDividaParcelaAcrescimo)
    {
        $this->fkDividaParcelaAcrescimos->removeElement($fkDividaParcelaAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaParcelaAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaAcrescimo
     */
    public function getFkDividaParcelaAcrescimos()
    {
        return $this->fkDividaParcelaAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoLevantamentoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoAcrescimo $fkFiscalizacaoLevantamentoAcrescimo
     * @return Acrescimo
     */
    public function addFkFiscalizacaoLevantamentoAcrescimos(\Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoAcrescimo $fkFiscalizacaoLevantamentoAcrescimo)
    {
        if (false === $this->fkFiscalizacaoLevantamentoAcrescimos->contains($fkFiscalizacaoLevantamentoAcrescimo)) {
            $fkFiscalizacaoLevantamentoAcrescimo->setFkMonetarioAcrescimo($this);
            $this->fkFiscalizacaoLevantamentoAcrescimos->add($fkFiscalizacaoLevantamentoAcrescimo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoLevantamentoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoAcrescimo $fkFiscalizacaoLevantamentoAcrescimo
     */
    public function removeFkFiscalizacaoLevantamentoAcrescimos(\Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoAcrescimo $fkFiscalizacaoLevantamentoAcrescimo)
    {
        $this->fkFiscalizacaoLevantamentoAcrescimos->removeElement($fkFiscalizacaoLevantamentoAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoLevantamentoAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoAcrescimo
     */
    public function getFkFiscalizacaoLevantamentoAcrescimos()
    {
        return $this->fkFiscalizacaoLevantamentoAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioAcrescimoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma $fkMonetarioAcrescimoNorma
     * @return Acrescimo
     */
    public function addFkMonetarioAcrescimoNormas(\Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma $fkMonetarioAcrescimoNorma)
    {
        if (false === $this->fkMonetarioAcrescimoNormas->contains($fkMonetarioAcrescimoNorma)) {
            $fkMonetarioAcrescimoNorma->setFkMonetarioAcrescimo($this);
            $this->fkMonetarioAcrescimoNormas->add($fkMonetarioAcrescimoNorma);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioAcrescimoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma $fkMonetarioAcrescimoNorma
     */
    public function removeFkMonetarioAcrescimoNormas(\Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma $fkMonetarioAcrescimoNorma)
    {
        $this->fkMonetarioAcrescimoNormas->removeElement($fkMonetarioAcrescimoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioAcrescimoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma
     */
    public function getFkMonetarioAcrescimoNormas()
    {
        return $this->fkMonetarioAcrescimoNormas;
    }

    /**
     * @param AcrescimoNorma $fkMonetarioAcrescimoNormas
     * @return $this
     */
    public function setFkMonetarioAcrescimoNormas(\Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma $fkMonetarioAcrescimoNormas)
    {
        $this->fkMonetarioAcrescimoNormas = $fkMonetarioAcrescimoNormas;
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioValorAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ValorAcrescimo $fkMonetarioValorAcrescimo
     * @return Acrescimo
     */
    public function addFkMonetarioValorAcrescimos(\Urbem\CoreBundle\Entity\Monetario\ValorAcrescimo $fkMonetarioValorAcrescimo)
    {
        if (false === $this->fkMonetarioValorAcrescimos->contains($fkMonetarioValorAcrescimo)) {
            $fkMonetarioValorAcrescimo->setFkMonetarioAcrescimo($this);
            $this->fkMonetarioValorAcrescimos->add($fkMonetarioValorAcrescimo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioValorAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ValorAcrescimo $fkMonetarioValorAcrescimo
     */
    public function removeFkMonetarioValorAcrescimos(\Urbem\CoreBundle\Entity\Monetario\ValorAcrescimo $fkMonetarioValorAcrescimo)
    {
        $this->fkMonetarioValorAcrescimos->removeElement($fkMonetarioValorAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioValorAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\ValorAcrescimo
     */
    public function getFkMonetarioValorAcrescimos()
    {
        return $this->fkMonetarioValorAcrescimos;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioFormulaAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo $fkMonetarioFormulaAcrescimo
     * @return Acrescimo
     */
    public function addFkMonetarioFormulaAcrescimos(\Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo $fkMonetarioFormulaAcrescimo)
    {
        if (false === $this->fkMonetarioFormulaAcrescimos->contains($fkMonetarioFormulaAcrescimo)) {
            $fkMonetarioFormulaAcrescimo->setFkMonetarioAcrescimo($this);
            $this->fkMonetarioFormulaAcrescimos->add($fkMonetarioFormulaAcrescimo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioFormulaAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo $fkMonetarioFormulaAcrescimo
     */
    public function removeFkMonetarioFormulaAcrescimos(\Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo $fkMonetarioFormulaAcrescimo)
    {
        $this->fkMonetarioFormulaAcrescimos->removeElement($fkMonetarioFormulaAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioFormulaAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo
     */
    public function getFkMonetarioFormulaAcrescimos()
    {
        return $this->fkMonetarioFormulaAcrescimos;
    }

    /**
     * @param FormulaAcrescimo $fkMonetarioFormulaAcrescimo
     * @return $this
     */
    public function setFkMonetarioFormulaAcrescimos(\Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo $fkMonetarioFormulaAcrescimo)
    {
        $this->fkMonetarioFormulaAcrescimo = $fkMonetarioFormulaAcrescimo;
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo $fkMonetarioCreditoAcrescimo
     * @return Acrescimo
     */
    public function addFkMonetarioCreditoAcrescimos(\Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo $fkMonetarioCreditoAcrescimo)
    {
        if (false === $this->fkMonetarioCreditoAcrescimos->contains($fkMonetarioCreditoAcrescimo)) {
            $fkMonetarioCreditoAcrescimo->setFkMonetarioAcrescimo($this);
            $this->fkMonetarioCreditoAcrescimos->add($fkMonetarioCreditoAcrescimo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo $fkMonetarioCreditoAcrescimo
     */
    public function removeFkMonetarioCreditoAcrescimos(\Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo $fkMonetarioCreditoAcrescimo)
    {
        $this->fkMonetarioCreditoAcrescimos->removeElement($fkMonetarioCreditoAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioCreditoAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo
     */
    public function getFkMonetarioCreditoAcrescimos()
    {
        return $this->fkMonetarioCreditoAcrescimos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioTipoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\TipoAcrescimo $fkMonetarioTipoAcrescimo
     * @return Acrescimo
     */
    public function setFkMonetarioTipoAcrescimo(\Urbem\CoreBundle\Entity\Monetario\TipoAcrescimo $fkMonetarioTipoAcrescimo)
    {
        $this->codTipo = $fkMonetarioTipoAcrescimo->getCodTipo();
        $this->fkMonetarioTipoAcrescimo = $fkMonetarioTipoAcrescimo;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioTipoAcrescimo
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\TipoAcrescimo
     */
    public function getFkMonetarioTipoAcrescimo()
    {
        return $this->fkMonetarioTipoAcrescimo;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        return (string) $this->descricaoAcrescimo;
    }
}
