<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * ContaCorrente
 */
class ContaCorrente
{
    /**
     * PK
     * @var integer
     */
    private $codBanco;

    /**
     * PK
     * @var integer
     */
    private $codAgencia;

    /**
     * PK
     * @var integer
     */
    private $codContaCorrente;

    /**
     * @var string
     */
    private $numContaCorrente;

    /**
     * @var \DateTime
     */
    private $dataCriacao;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    private $fkContabilidadePlanoBancos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulConta
     */
    private $fkImaConfiguracaoBanrisulContas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioCaixaEconomicaFederal
     */
    private $fkImaConfiguracaoConvenioCaixaEconomicaFederais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBradesco
     */
    private $fkImaConfiguracaoConvenioBradescos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep
     */
    private $fkImaConfiguracaoPaseps;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio
     */
    private $fkMonetarioContaCorrenteConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\RelacaoContaCorrenteFontePagadora
     */
    private $fkTcepbRelacaoContaCorrenteFontePagadoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho
     */
    private $fkTcmbaSubvencaoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Cheque
     */
    private $fkTesourariaCheques;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta
     */
    private $fkImaConfiguracaoBescContas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta
     */
    private $fkImaConfiguracaoBbContas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta
     */
    private $fkImaConfiguracaoHsbcContas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    private $fkMonetarioAgencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\TipoConta
     */
    private $fkMonetarioTipoConta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadePlanoBancos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBanrisulContas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoConvenioCaixaEconomicaFederais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoConvenioBradescos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoPaseps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioContaCorrenteConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcepbRelacaoContaCorrenteFontePagadoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcmbaSubvencaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaCheques = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBescContas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoBbContas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoHsbcContas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return ContaCorrente
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return ContaCorrente
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codContaCorrente
     *
     * @param integer $codContaCorrente
     * @return ContaCorrente
     */
    public function setCodContaCorrente($codContaCorrente)
    {
        $this->codContaCorrente = $codContaCorrente;
        return $this;
    }

    /**
     * Get codContaCorrente
     *
     * @return integer
     */
    public function getCodContaCorrente()
    {
        return $this->codContaCorrente;
    }

    /**
     * Set numContaCorrente
     *
     * @param string $numContaCorrente
     * @return ContaCorrente
     */
    public function setNumContaCorrente($numContaCorrente)
    {
        $this->numContaCorrente = $numContaCorrente;
        return $this;
    }

    /**
     * Get numContaCorrente
     *
     * @return string
     */
    public function getNumContaCorrente()
    {
        return $this->numContaCorrente;
    }

    /**
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     * @return ContaCorrente
     */
    public function setDataCriacao(\DateTime $dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;
        return $this;
    }

    /**
     * Get dataCriacao
     *
     * @return \DateTime
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ContaCorrente
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
     * Add ContabilidadePlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco
     * @return ContaCorrente
     */
    public function addFkContabilidadePlanoBancos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco)
    {
        if (false === $this->fkContabilidadePlanoBancos->contains($fkContabilidadePlanoBanco)) {
            $fkContabilidadePlanoBanco->setFkMonetarioContaCorrente($this);
            $this->fkContabilidadePlanoBancos->add($fkContabilidadePlanoBanco);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePlanoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco
     */
    public function removeFkContabilidadePlanoBancos(\Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco $fkContabilidadePlanoBanco)
    {
        $this->fkContabilidadePlanoBancos->removeElement($fkContabilidadePlanoBanco);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePlanoBancos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco
     */
    public function getFkContabilidadePlanoBancos()
    {
        return $this->fkContabilidadePlanoBancos;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBanrisulConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulConta $fkImaConfiguracaoBanrisulConta
     * @return ContaCorrente
     */
    public function addFkImaConfiguracaoBanrisulContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulConta $fkImaConfiguracaoBanrisulConta)
    {
        if (false === $this->fkImaConfiguracaoBanrisulContas->contains($fkImaConfiguracaoBanrisulConta)) {
            $fkImaConfiguracaoBanrisulConta->setFkMonetarioContaCorrente($this);
            $this->fkImaConfiguracaoBanrisulContas->add($fkImaConfiguracaoBanrisulConta);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBanrisulConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulConta $fkImaConfiguracaoBanrisulConta
     */
    public function removeFkImaConfiguracaoBanrisulContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulConta $fkImaConfiguracaoBanrisulConta)
    {
        $this->fkImaConfiguracaoBanrisulContas->removeElement($fkImaConfiguracaoBanrisulConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBanrisulContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanrisulConta
     */
    public function getFkImaConfiguracaoBanrisulContas()
    {
        return $this->fkImaConfiguracaoBanrisulContas;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoConvenioCaixaEconomicaFederal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioCaixaEconomicaFederal $fkImaConfiguracaoConvenioCaixaEconomicaFederal
     * @return ContaCorrente
     */
    public function addFkImaConfiguracaoConvenioCaixaEconomicaFederais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioCaixaEconomicaFederal $fkImaConfiguracaoConvenioCaixaEconomicaFederal)
    {
        if (false === $this->fkImaConfiguracaoConvenioCaixaEconomicaFederais->contains($fkImaConfiguracaoConvenioCaixaEconomicaFederal)) {
            $fkImaConfiguracaoConvenioCaixaEconomicaFederal->setFkMonetarioContaCorrente($this);
            $this->fkImaConfiguracaoConvenioCaixaEconomicaFederais->add($fkImaConfiguracaoConvenioCaixaEconomicaFederal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoConvenioCaixaEconomicaFederal
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioCaixaEconomicaFederal $fkImaConfiguracaoConvenioCaixaEconomicaFederal
     */
    public function removeFkImaConfiguracaoConvenioCaixaEconomicaFederais(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioCaixaEconomicaFederal $fkImaConfiguracaoConvenioCaixaEconomicaFederal)
    {
        $this->fkImaConfiguracaoConvenioCaixaEconomicaFederais->removeElement($fkImaConfiguracaoConvenioCaixaEconomicaFederal);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoConvenioCaixaEconomicaFederais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioCaixaEconomicaFederal
     */
    public function getFkImaConfiguracaoConvenioCaixaEconomicaFederais()
    {
        return $this->fkImaConfiguracaoConvenioCaixaEconomicaFederais;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoConvenioBradesco
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBradesco $fkImaConfiguracaoConvenioBradesco
     * @return ContaCorrente
     */
    public function addFkImaConfiguracaoConvenioBradescos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBradesco $fkImaConfiguracaoConvenioBradesco)
    {
        if (false === $this->fkImaConfiguracaoConvenioBradescos->contains($fkImaConfiguracaoConvenioBradesco)) {
            $fkImaConfiguracaoConvenioBradesco->setFkMonetarioContaCorrente($this);
            $this->fkImaConfiguracaoConvenioBradescos->add($fkImaConfiguracaoConvenioBradesco);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoConvenioBradesco
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBradesco $fkImaConfiguracaoConvenioBradesco
     */
    public function removeFkImaConfiguracaoConvenioBradescos(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBradesco $fkImaConfiguracaoConvenioBradesco)
    {
        $this->fkImaConfiguracaoConvenioBradescos->removeElement($fkImaConfiguracaoConvenioBradesco);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoConvenioBradescos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBradesco
     */
    public function getFkImaConfiguracaoConvenioBradescos()
    {
        return $this->fkImaConfiguracaoConvenioBradescos;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoPasep
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep $fkImaConfiguracaoPasep
     * @return ContaCorrente
     */
    public function addFkImaConfiguracaoPaseps(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep $fkImaConfiguracaoPasep)
    {
        if (false === $this->fkImaConfiguracaoPaseps->contains($fkImaConfiguracaoPasep)) {
            $fkImaConfiguracaoPasep->setFkMonetarioContaCorrente($this);
            $this->fkImaConfiguracaoPaseps->add($fkImaConfiguracaoPasep);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoPasep
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep $fkImaConfiguracaoPasep
     */
    public function removeFkImaConfiguracaoPaseps(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep $fkImaConfiguracaoPasep)
    {
        $this->fkImaConfiguracaoPaseps->removeElement($fkImaConfiguracaoPasep);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoPaseps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep
     */
    public function getFkImaConfiguracaoPaseps()
    {
        return $this->fkImaConfiguracaoPaseps;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioContaCorrenteConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio $fkMonetarioContaCorrenteConvenio
     * @return ContaCorrente
     */
    public function addFkMonetarioContaCorrenteConvenios(\Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio $fkMonetarioContaCorrenteConvenio)
    {
        if (false === $this->fkMonetarioContaCorrenteConvenios->contains($fkMonetarioContaCorrenteConvenio)) {
            $fkMonetarioContaCorrenteConvenio->setFkMonetarioContaCorrente($this);
            $this->fkMonetarioContaCorrenteConvenios->add($fkMonetarioContaCorrenteConvenio);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioContaCorrenteConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio $fkMonetarioContaCorrenteConvenio
     */
    public function removeFkMonetarioContaCorrenteConvenios(\Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio $fkMonetarioContaCorrenteConvenio)
    {
        $this->fkMonetarioContaCorrenteConvenios->removeElement($fkMonetarioContaCorrenteConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioContaCorrenteConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio
     */
    public function getFkMonetarioContaCorrenteConvenios()
    {
        return $this->fkMonetarioContaCorrenteConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add TcepbRelacaoContaCorrenteFontePagadora
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\RelacaoContaCorrenteFontePagadora $fkTcepbRelacaoContaCorrenteFontePagadora
     * @return ContaCorrente
     */
    public function addFkTcepbRelacaoContaCorrenteFontePagadoras(\Urbem\CoreBundle\Entity\Tcepb\RelacaoContaCorrenteFontePagadora $fkTcepbRelacaoContaCorrenteFontePagadora)
    {
        if (false === $this->fkTcepbRelacaoContaCorrenteFontePagadoras->contains($fkTcepbRelacaoContaCorrenteFontePagadora)) {
            $fkTcepbRelacaoContaCorrenteFontePagadora->setFkMonetarioContaCorrente($this);
            $this->fkTcepbRelacaoContaCorrenteFontePagadoras->add($fkTcepbRelacaoContaCorrenteFontePagadora);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcepbRelacaoContaCorrenteFontePagadora
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\RelacaoContaCorrenteFontePagadora $fkTcepbRelacaoContaCorrenteFontePagadora
     */
    public function removeFkTcepbRelacaoContaCorrenteFontePagadoras(\Urbem\CoreBundle\Entity\Tcepb\RelacaoContaCorrenteFontePagadora $fkTcepbRelacaoContaCorrenteFontePagadora)
    {
        $this->fkTcepbRelacaoContaCorrenteFontePagadoras->removeElement($fkTcepbRelacaoContaCorrenteFontePagadora);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcepbRelacaoContaCorrenteFontePagadoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcepb\RelacaoContaCorrenteFontePagadora
     */
    public function getFkTcepbRelacaoContaCorrenteFontePagadoras()
    {
        return $this->fkTcepbRelacaoContaCorrenteFontePagadoras;
    }

    /**
     * OneToMany (owning side)
     * Add TcmbaSubvencaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho
     * @return ContaCorrente
     */
    public function addFkTcmbaSubvencaoEmpenhos(\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho)
    {
        if (false === $this->fkTcmbaSubvencaoEmpenhos->contains($fkTcmbaSubvencaoEmpenho)) {
            $fkTcmbaSubvencaoEmpenho->setFkMonetarioContaCorrente($this);
            $this->fkTcmbaSubvencaoEmpenhos->add($fkTcmbaSubvencaoEmpenho);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaSubvencaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho
     */
    public function removeFkTcmbaSubvencaoEmpenhos(\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho $fkTcmbaSubvencaoEmpenho)
    {
        $this->fkTcmbaSubvencaoEmpenhos->removeElement($fkTcmbaSubvencaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaSubvencaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\SubvencaoEmpenho
     */
    public function getFkTcmbaSubvencaoEmpenhos()
    {
        return $this->fkTcmbaSubvencaoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaCheque
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Cheque $fkTesourariaCheque
     * @return ContaCorrente
     */
    public function addFkTesourariaCheques(\Urbem\CoreBundle\Entity\Tesouraria\Cheque $fkTesourariaCheque)
    {
        if (false === $this->fkTesourariaCheques->contains($fkTesourariaCheque)) {
            $fkTesourariaCheque->setFkMonetarioContaCorrente($this);
            $this->fkTesourariaCheques->add($fkTesourariaCheque);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaCheque
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Cheque $fkTesourariaCheque
     */
    public function removeFkTesourariaCheques(\Urbem\CoreBundle\Entity\Tesouraria\Cheque $fkTesourariaCheque)
    {
        $this->fkTesourariaCheques->removeElement($fkTesourariaCheque);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaCheques
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\Cheque
     */
    public function getFkTesourariaCheques()
    {
        return $this->fkTesourariaCheques;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBescConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta $fkImaConfiguracaoBescConta
     * @return ContaCorrente
     */
    public function addFkImaConfiguracaoBescContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta $fkImaConfiguracaoBescConta)
    {
        if (false === $this->fkImaConfiguracaoBescContas->contains($fkImaConfiguracaoBescConta)) {
            $fkImaConfiguracaoBescConta->setFkMonetarioContaCorrente($this);
            $this->fkImaConfiguracaoBescContas->add($fkImaConfiguracaoBescConta);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBescConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta $fkImaConfiguracaoBescConta
     */
    public function removeFkImaConfiguracaoBescContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta $fkImaConfiguracaoBescConta)
    {
        $this->fkImaConfiguracaoBescContas->removeElement($fkImaConfiguracaoBescConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBescContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBescConta
     */
    public function getFkImaConfiguracaoBescContas()
    {
        return $this->fkImaConfiguracaoBescContas;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoBbConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta $fkImaConfiguracaoBbConta
     * @return ContaCorrente
     */
    public function addFkImaConfiguracaoBbContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta $fkImaConfiguracaoBbConta)
    {
        if (false === $this->fkImaConfiguracaoBbContas->contains($fkImaConfiguracaoBbConta)) {
            $fkImaConfiguracaoBbConta->setFkMonetarioContaCorrente($this);
            $this->fkImaConfiguracaoBbContas->add($fkImaConfiguracaoBbConta);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoBbConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta $fkImaConfiguracaoBbConta
     */
    public function removeFkImaConfiguracaoBbContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta $fkImaConfiguracaoBbConta)
    {
        $this->fkImaConfiguracaoBbContas->removeElement($fkImaConfiguracaoBbConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoBbContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoBbConta
     */
    public function getFkImaConfiguracaoBbContas()
    {
        return $this->fkImaConfiguracaoBbContas;
    }

    /**
     * OneToMany (owning side)
     * Add ImaConfiguracaoHsbcConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta $fkImaConfiguracaoHsbcConta
     * @return ContaCorrente
     */
    public function addFkImaConfiguracaoHsbcContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta $fkImaConfiguracaoHsbcConta)
    {
        if (false === $this->fkImaConfiguracaoHsbcContas->contains($fkImaConfiguracaoHsbcConta)) {
            $fkImaConfiguracaoHsbcConta->setFkMonetarioContaCorrente($this);
            $this->fkImaConfiguracaoHsbcContas->add($fkImaConfiguracaoHsbcConta);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoHsbcConta
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta $fkImaConfiguracaoHsbcConta
     */
    public function removeFkImaConfiguracaoHsbcContas(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta $fkImaConfiguracaoHsbcConta)
    {
        $this->fkImaConfiguracaoHsbcContas->removeElement($fkImaConfiguracaoHsbcConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoHsbcContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta
     */
    public function getFkImaConfiguracaoHsbcContas()
    {
        return $this->fkImaConfiguracaoHsbcContas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     * @return ContaCorrente
     */
    public function setFkMonetarioAgencia(\Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia)
    {
        $this->codBanco = $fkMonetarioAgencia->getCodBanco();
        $this->codAgencia = $fkMonetarioAgencia->getCodAgencia();
        $this->fkMonetarioAgencia = $fkMonetarioAgencia;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioAgencia
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    public function getFkMonetarioAgencia()
    {
        return $this->fkMonetarioAgencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioTipoConta
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\TipoConta $fkMonetarioTipoConta
     * @return ContaCorrente
     */
    public function setFkMonetarioTipoConta(\Urbem\CoreBundle\Entity\Monetario\TipoConta $fkMonetarioTipoConta)
    {
        $this->codTipo = $fkMonetarioTipoConta->getCodTipo();
        $this->fkMonetarioTipoConta = $fkMonetarioTipoConta;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioTipoConta
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\TipoConta
     */
    public function getFkMonetarioTipoConta()
    {
        return $this->fkMonetarioTipoConta;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->numContaCorrente;
    }
}
