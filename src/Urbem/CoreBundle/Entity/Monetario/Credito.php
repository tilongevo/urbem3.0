<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * Credito
 */
class Credito
{
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
     * @var string
     */
    private $descricaoCredito;

    /**
     * @var integer
     */
    private $codConvenio;

    /**
     * @var integer
     */
    private $iReceitas;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Monetario\RegraDesoneracaoCredito
     */
    private $fkMonetarioRegraDesoneracaoCredito;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Monetario\CreditoContaCorrente
     */
    private $fkMonetarioCreditoContaCorrente;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Monetario\CreditoCarteira
     */
    private $fkMonetarioCreditoCarteira;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    private $fkArrecadacaoCalculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    private $fkArrecadacaoDesoneracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo
     */
    private $fkArrecadacaoParametroCalculos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCredito
     */
    private $fkContabilidadePlanoAnaliticaCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaOrigem
     */
    private $fkDividaParcelaOrigens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCredito
     */
    private $fkFiscalizacaoProcessoFiscalCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo
     */
    private $fkMonetarioCreditoAcrescimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoNorma
     */
    private $fkMonetarioCreditoNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoIndicador
     */
    private $fkMonetarioCreditoIndicadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoMoeda
     */
    private $fkMonetarioCreditoMoedas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\DespesaCredito
     */
    private $fkOrcamentoDespesaCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito
     */
    private $fkOrcamentoReceitaCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo
     */
    private $fkArrecadacaoCreditoGrupos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\EspecieCredito
     */
    private $fkMonetarioEspecieCredito;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Convenio
     */
    private $fkMonetarioConvenio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoCalculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDesoneracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoParametroCalculos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkContabilidadePlanoAnaliticaCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaParcelaOrigens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoProcessoFiscalCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioCreditoAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioCreditoNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioCreditoIndicadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioCreditoMoedas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoDespesaCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkOrcamentoReceitaCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoCreditoGrupos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCredito
     *
     * @param integer $codCredito
     * @return Credito
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
     * @return Credito
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
     * @return Credito
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
     * @return Credito
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
     * Set descricaoCredito
     *
     * @param string $descricaoCredito
     * @return Credito
     */
    public function setDescricaoCredito($descricaoCredito)
    {
        $this->descricaoCredito = $descricaoCredito;
        return $this;
    }

    /**
     * Get descricaoCredito
     *
     * @return string
     */
    public function getDescricaoCredito()
    {
        return $this->descricaoCredito;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return Credito
     */
    public function setCodConvenio($codConvenio = null)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set iReceitas
     *
     * @param integer $iReceitas
     * @return Credito
     */
    public function setIReceitas($iReceitas = null)
    {
        $this->iReceitas = $iReceitas;
        return $this;
    }

    /**
     * Get iReceitas
     *
     * @return integer
     */
    public function getIReceitas()
    {
        return $this->iReceitas;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo
     * @return Credito
     */
    public function addFkArrecadacaoCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo)
    {
        if (false === $this->fkArrecadacaoCalculos->contains($fkArrecadacaoCalculo)) {
            $fkArrecadacaoCalculo->setFkMonetarioCredito($this);
            $this->fkArrecadacaoCalculos->add($fkArrecadacaoCalculo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo
     */
    public function removeFkArrecadacaoCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo)
    {
        $this->fkArrecadacaoCalculos->removeElement($fkArrecadacaoCalculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCalculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    public function getFkArrecadacaoCalculos()
    {
        return $this->fkArrecadacaoCalculos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao
     * @return Credito
     */
    public function addFkArrecadacaoDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao)
    {
        if (false === $this->fkArrecadacaoDesoneracoes->contains($fkArrecadacaoDesoneracao)) {
            $fkArrecadacaoDesoneracao->setFkMonetarioCredito($this);
            $this->fkArrecadacaoDesoneracoes->add($fkArrecadacaoDesoneracao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao
     */
    public function removeFkArrecadacaoDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao)
    {
        $this->fkArrecadacaoDesoneracoes->removeElement($fkArrecadacaoDesoneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDesoneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    public function getFkArrecadacaoDesoneracoes()
    {
        return $this->fkArrecadacaoDesoneracoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoParametroCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo $fkArrecadacaoParametroCalculo
     * @return Credito
     */
    public function addFkArrecadacaoParametroCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo $fkArrecadacaoParametroCalculo)
    {
        if (false === $this->fkArrecadacaoParametroCalculos->contains($fkArrecadacaoParametroCalculo)) {
            $fkArrecadacaoParametroCalculo->setFkMonetarioCredito($this);
            $this->fkArrecadacaoParametroCalculos->add($fkArrecadacaoParametroCalculo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoParametroCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo $fkArrecadacaoParametroCalculo
     */
    public function removeFkArrecadacaoParametroCalculos(\Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo $fkArrecadacaoParametroCalculo)
    {
        $this->fkArrecadacaoParametroCalculos->removeElement($fkArrecadacaoParametroCalculo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoParametroCalculos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo
     */
    public function getFkArrecadacaoParametroCalculos()
    {
        return $this->fkArrecadacaoParametroCalculos;
    }

    /**
     * OneToMany (owning side)
     * Add ContabilidadePlanoAnaliticaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCredito $fkContabilidadePlanoAnaliticaCredito
     * @return Credito
     */
    public function addFkContabilidadePlanoAnaliticaCreditos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCredito $fkContabilidadePlanoAnaliticaCredito)
    {
        if (false === $this->fkContabilidadePlanoAnaliticaCreditos->contains($fkContabilidadePlanoAnaliticaCredito)) {
            $fkContabilidadePlanoAnaliticaCredito->setFkMonetarioCredito($this);
            $this->fkContabilidadePlanoAnaliticaCreditos->add($fkContabilidadePlanoAnaliticaCredito);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoAnaliticaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCredito $fkContabilidadePlanoAnaliticaCredito
     */
    public function removeFkContabilidadePlanoAnaliticaCreditos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCredito $fkContabilidadePlanoAnaliticaCredito)
    {
        $this->fkContabilidadePlanoAnaliticaCreditos->removeElement($fkContabilidadePlanoAnaliticaCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoAnaliticaCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnaliticaCredito
     */
    public function getFkContabilidadePlanoAnaliticaCreditos()
    {
        return $this->fkContabilidadePlanoAnaliticaCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add DividaParcelaOrigem
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaOrigem $fkDividaParcelaOrigem
     * @return Credito
     */
    public function addFkDividaParcelaOrigens(\Urbem\CoreBundle\Entity\Divida\ParcelaOrigem $fkDividaParcelaOrigem)
    {
        if (false === $this->fkDividaParcelaOrigens->contains($fkDividaParcelaOrigem)) {
            $fkDividaParcelaOrigem->setFkMonetarioCredito($this);
            $this->fkDividaParcelaOrigens->add($fkDividaParcelaOrigem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaParcelaOrigem
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ParcelaOrigem $fkDividaParcelaOrigem
     */
    public function removeFkDividaParcelaOrigens(\Urbem\CoreBundle\Entity\Divida\ParcelaOrigem $fkDividaParcelaOrigem)
    {
        $this->fkDividaParcelaOrigens->removeElement($fkDividaParcelaOrigem);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaParcelaOrigens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ParcelaOrigem
     */
    public function getFkDividaParcelaOrigens()
    {
        return $this->fkDividaParcelaOrigens;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoProcessoFiscalCredito
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCredito $fkFiscalizacaoProcessoFiscalCredito
     * @return Credito
     */
    public function addFkFiscalizacaoProcessoFiscalCreditos(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCredito $fkFiscalizacaoProcessoFiscalCredito)
    {
        if (false === $this->fkFiscalizacaoProcessoFiscalCreditos->contains($fkFiscalizacaoProcessoFiscalCredito)) {
            $fkFiscalizacaoProcessoFiscalCredito->setFkMonetarioCredito($this);
            $this->fkFiscalizacaoProcessoFiscalCreditos->add($fkFiscalizacaoProcessoFiscalCredito);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoFiscalCredito
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCredito $fkFiscalizacaoProcessoFiscalCredito
     */
    public function removeFkFiscalizacaoProcessoFiscalCreditos(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCredito $fkFiscalizacaoProcessoFiscalCredito)
    {
        $this->fkFiscalizacaoProcessoFiscalCreditos->removeElement($fkFiscalizacaoProcessoFiscalCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoFiscalCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalCredito
     */
    public function getFkFiscalizacaoProcessoFiscalCreditos()
    {
        return $this->fkFiscalizacaoProcessoFiscalCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioCreditoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo $fkMonetarioCreditoAcrescimo
     * @return Credito
     */
    public function addFkMonetarioCreditoAcrescimo(\Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo $fkMonetarioCreditoAcrescimo)
    {
        if (false === $this->fkMonetarioCreditoAcrescimos->contains($fkMonetarioCreditoAcrescimo)) {
            $fkMonetarioCreditoAcrescimo->setFkMonetarioCredito($this);
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
    public function removeFkMonetarioCreditoAcrescimo(\Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo $fkMonetarioCreditoAcrescimo)
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
     * OneToMany (owning side)
     * Add MonetarioCreditoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoNorma $fkMonetarioCreditoNorma
     * @return Credito
     */
    public function addFkMonetarioCreditoNorma(\Urbem\CoreBundle\Entity\Monetario\CreditoNorma $fkMonetarioCreditoNorma)
    {
        if (false === $this->fkMonetarioCreditoNormas->contains($fkMonetarioCreditoNorma)) {
            $fkMonetarioCreditoNorma->setFkMonetarioCredito($this);
            $this->fkMonetarioCreditoNormas->add($fkMonetarioCreditoNorma);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioCreditoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoNorma $fkMonetarioCreditoNorma
     */
    public function removeFkMonetarioCreditoNorma(\Urbem\CoreBundle\Entity\Monetario\CreditoNorma $fkMonetarioCreditoNorma)
    {
        $this->fkMonetarioCreditoNormas->removeElement($fkMonetarioCreditoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioCreditoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoNorma
     */
    public function getFkMonetarioCreditoNormas()
    {
        return $this->fkMonetarioCreditoNormas;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioCreditoIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoIndicador $fkMonetarioCreditoIndicador
     * @return Credito
     */
    public function addFkMonetarioCreditoIndicadores(\Urbem\CoreBundle\Entity\Monetario\CreditoIndicador $fkMonetarioCreditoIndicador)
    {
        if (false === $this->fkMonetarioCreditoIndicadores->contains($fkMonetarioCreditoIndicador)) {
            $fkMonetarioCreditoIndicador->setFkMonetarioCredito($this);
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
     * Add MonetarioCreditoMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoMoeda $fkMonetarioCreditoMoeda
     * @return Credito
     */
    public function addFkMonetarioCreditoMoedas(\Urbem\CoreBundle\Entity\Monetario\CreditoMoeda $fkMonetarioCreditoMoeda)
    {
        if (false === $this->fkMonetarioCreditoMoedas->contains($fkMonetarioCreditoMoeda)) {
            $fkMonetarioCreditoMoeda->setFkMonetarioCredito($this);
            $this->fkMonetarioCreditoMoedas->add($fkMonetarioCreditoMoeda);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioCreditoMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoMoeda $fkMonetarioCreditoMoeda
     */
    public function removeFkMonetarioCreditoMoedas(\Urbem\CoreBundle\Entity\Monetario\CreditoMoeda $fkMonetarioCreditoMoeda)
    {
        $this->fkMonetarioCreditoMoedas->removeElement($fkMonetarioCreditoMoeda);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioCreditoMoedas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\CreditoMoeda
     */
    public function getFkMonetarioCreditoMoedas()
    {
        return $this->fkMonetarioCreditoMoedas;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoDespesaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\DespesaCredito $fkOrcamentoDespesaCredito
     * @return Credito
     */
    public function addFkOrcamentoDespesaCreditos(\Urbem\CoreBundle\Entity\Orcamento\DespesaCredito $fkOrcamentoDespesaCredito)
    {
        if (false === $this->fkOrcamentoDespesaCreditos->contains($fkOrcamentoDespesaCredito)) {
            $fkOrcamentoDespesaCredito->setFkMonetarioCredito($this);
            $this->fkOrcamentoDespesaCreditos->add($fkOrcamentoDespesaCredito);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoDespesaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\DespesaCredito $fkOrcamentoDespesaCredito
     */
    public function removeFkOrcamentoDespesaCreditos(\Urbem\CoreBundle\Entity\Orcamento\DespesaCredito $fkOrcamentoDespesaCredito)
    {
        $this->fkOrcamentoDespesaCreditos->removeElement($fkOrcamentoDespesaCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoDespesaCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\DespesaCredito
     */
    public function getFkOrcamentoDespesaCreditos()
    {
        return $this->fkOrcamentoDespesaCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add OrcamentoReceitaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito $fkOrcamentoReceitaCredito
     * @return Credito
     */
    public function addFkOrcamentoReceitaCreditos(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito $fkOrcamentoReceitaCredito)
    {
        if (false === $this->fkOrcamentoReceitaCreditos->contains($fkOrcamentoReceitaCredito)) {
            $fkOrcamentoReceitaCredito->setFkMonetarioCredito($this);
            $this->fkOrcamentoReceitaCreditos->add($fkOrcamentoReceitaCredito);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove OrcamentoReceitaCredito
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito $fkOrcamentoReceitaCredito
     */
    public function removeFkOrcamentoReceitaCreditos(\Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito $fkOrcamentoReceitaCredito)
    {
        $this->fkOrcamentoReceitaCreditos->removeElement($fkOrcamentoReceitaCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkOrcamentoReceitaCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Orcamento\ReceitaCredito
     */
    public function getFkOrcamentoReceitaCreditos()
    {
        return $this->fkOrcamentoReceitaCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCreditoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo $fkArrecadacaoCreditoGrupo
     * @return Credito
     */
    public function addFkArrecadacaoCreditoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo $fkArrecadacaoCreditoGrupo)
    {
        if (false === $this->fkArrecadacaoCreditoGrupos->contains($fkArrecadacaoCreditoGrupo)) {
            $fkArrecadacaoCreditoGrupo->setFkMonetarioCredito($this);
            $this->fkArrecadacaoCreditoGrupos->add($fkArrecadacaoCreditoGrupo);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCreditoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo $fkArrecadacaoCreditoGrupo
     */
    public function removeFkArrecadacaoCreditoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo $fkArrecadacaoCreditoGrupo)
    {
        $this->fkArrecadacaoCreditoGrupos->removeElement($fkArrecadacaoCreditoGrupo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCreditoGrupos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo
     */
    public function getFkArrecadacaoCreditoGrupos()
    {
        return $this->fkArrecadacaoCreditoGrupos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioEspecieCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\EspecieCredito $fkMonetarioEspecieCredito
     * @return Credito
     */
    public function setFkMonetarioEspecieCredito(\Urbem\CoreBundle\Entity\Monetario\EspecieCredito $fkMonetarioEspecieCredito)
    {
        $this->codEspecie = $fkMonetarioEspecieCredito->getCodEspecie();
        $this->codGenero = $fkMonetarioEspecieCredito->getCodGenero();
        $this->codNatureza = $fkMonetarioEspecieCredito->getCodNatureza();
        $this->fkMonetarioEspecieCredito = $fkMonetarioEspecieCredito;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioEspecieCredito
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\EspecieCredito
     */
    public function getFkMonetarioEspecieCredito()
    {
        return $this->fkMonetarioEspecieCredito;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio
     * @return Credito
     */
    public function setFkMonetarioConvenio(\Urbem\CoreBundle\Entity\Monetario\Convenio $fkMonetarioConvenio)
    {
        $this->codConvenio = $fkMonetarioConvenio->getCodConvenio();
        $this->fkMonetarioConvenio = $fkMonetarioConvenio;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Convenio
     */
    public function getFkMonetarioConvenio()
    {
        return $this->fkMonetarioConvenio;
    }

    /**
     * OneToOne (inverse side)
     * Set MonetarioRegraDesoneracaoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\RegraDesoneracaoCredito $fkMonetarioRegraDesoneracaoCredito
     * @return Credito
     */
    public function setFkMonetarioRegraDesoneracaoCredito(\Urbem\CoreBundle\Entity\Monetario\RegraDesoneracaoCredito $fkMonetarioRegraDesoneracaoCredito)
    {
        $fkMonetarioRegraDesoneracaoCredito->setFkMonetarioCredito($this);
        $this->fkMonetarioRegraDesoneracaoCredito = $fkMonetarioRegraDesoneracaoCredito;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkMonetarioRegraDesoneracaoCredito
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\RegraDesoneracaoCredito
     */
    public function getFkMonetarioRegraDesoneracaoCredito()
    {
        return $this->fkMonetarioRegraDesoneracaoCredito;
    }

    /**
     * OneToOne (inverse side)
     * Set MonetarioCreditoContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoContaCorrente $fkMonetarioCreditoContaCorrente
     * @return Credito
     */
    public function setFkMonetarioCreditoContaCorrente(\Urbem\CoreBundle\Entity\Monetario\CreditoContaCorrente $fkMonetarioCreditoContaCorrente)
    {
        $fkMonetarioCreditoContaCorrente->setFkMonetarioCredito($this);
        $this->fkMonetarioCreditoContaCorrente = $fkMonetarioCreditoContaCorrente;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkMonetarioCreditoContaCorrente
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\CreditoContaCorrente
     */
    public function getFkMonetarioCreditoContaCorrente()
    {
        return $this->fkMonetarioCreditoContaCorrente;
    }

    /**
     * OneToOne (inverse side)
     * Set MonetarioCreditoCarteira
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\CreditoCarteira $fkMonetarioCreditoCarteira
     * @return Credito
     */
    public function setFkMonetarioCreditoCarteira(\Urbem\CoreBundle\Entity\Monetario\CreditoCarteira $fkMonetarioCreditoCarteira)
    {
        $fkMonetarioCreditoCarteira->setFkMonetarioCredito($this);
        $this->fkMonetarioCreditoCarteira = $fkMonetarioCreditoCarteira;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkMonetarioCreditoCarteira
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\CreditoCarteira
     */
    public function getFkMonetarioCreditoCarteira()
    {
        return $this->fkMonetarioCreditoCarteira;
    }

    /**
     * @return string
     */
    public function getCodigoComposto()
    {
        return sprintf(
            '%s.%s.%s.%s',
            str_pad($this->codCredito, 3, '0', STR_PAD_LEFT),
            str_pad($this->codGenero, 2, '0', STR_PAD_LEFT),
            str_pad($this->codEspecie, 3, '0', STR_PAD_LEFT),
            $this->codNatureza
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->getCodigoComposto(), $this->descricaoCredito);
    }
}
