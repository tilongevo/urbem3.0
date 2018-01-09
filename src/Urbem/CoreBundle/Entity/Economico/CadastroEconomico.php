<?php

namespace Urbem\CoreBundle\Entity\Economico;

/**
 * CadastroEconomico
 */
class CadastroEconomico
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtAbertura;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo
     */
    private $fkEconomicoCadastroEconomicoAutonomo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato
     */
    private $fkEconomicoCadastroEconomicoEmpresaFato;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito
     */
    private $fkEconomicoCadastroEconomicoEmpresaDireito;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento
     */
    private $fkArrecadacaoCadastroEconomicoFaturamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa
     */
    private $fkArrecadacaoDocumentoEmpresas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico
     */
    private $fkArrecadacaoDesoneradoCadEconomicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\TomadorEmpresa
     */
    private $fkArrecadacaoTomadorEmpresas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaEmpresa
     */
    private $fkDividaDividaEmpresas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico
     */
    private $fkEconomicoAtividadeCadastroEconomicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DomicilioFiscal
     */
    private $fkEconomicoDomicilioFiscais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil
     */
    private $fkEconomicoCadastroEconRespContabiis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico
     */
    private $fkEconomicoCadastroEconRespTecnicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DomicilioInformado
     */
    private $fkEconomicoDomicilioInformados;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico
     */
    private $fkEconomicoDiasCadastroEconomicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico
     */
    private $fkEconomicoBaixaCadastroEconomicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico
     */
    private $fkEconomicoProcessoCadastroEconomicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\UsoSoloEmpresa
     */
    private $fkEconomicoUsoSoloEmpresas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon
     */
    private $fkEconomicoProcessoAtividadeCadEcons;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas
     */
    private $fkFiscalizacaoAutorizacaoNotas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoLivro
     */
    private $fkFiscalizacaoAutenticacaoLivros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa
     */
    private $fkFiscalizacaoProcessoFiscalEmpresas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoCadastroEconomicoFaturamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDocumentoEmpresas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDesoneradoCadEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoTomadorEmpresas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkDividaDividaEmpresas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtividadeCadastroEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoDomicilioFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoCadastroEconRespContabiis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoCadastroEconRespTecnicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoDomicilioInformados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoDiasCadastroEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoBaixaCadastroEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoCadastroEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoUsoSoloEmpresas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoProcessoAtividadeCadEcons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoAutorizacaoNotas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoAutenticacaoLivros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoProcessoFiscalEmpresas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return CadastroEconomico
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CadastroEconomico
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set dtAbertura
     *
     * @param \DateTime $dtAbertura
     * @return CadastroEconomico
     */
    public function setDtAbertura(\DateTime $dtAbertura)
    {
        $this->dtAbertura = $dtAbertura;
        return $this;
    }

    /**
     * Get dtAbertura
     *
     * @return \DateTime
     */
    public function getDtAbertura()
    {
        return $this->dtAbertura;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCadastroEconomicoFaturamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento $fkArrecadacaoCadastroEconomicoFaturamento
     * @return CadastroEconomico
     */
    public function addFkArrecadacaoCadastroEconomicoFaturamentos(\Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento $fkArrecadacaoCadastroEconomicoFaturamento)
    {
        if (false === $this->fkArrecadacaoCadastroEconomicoFaturamentos->contains($fkArrecadacaoCadastroEconomicoFaturamento)) {
            $fkArrecadacaoCadastroEconomicoFaturamento->setFkEconomicoCadastroEconomico($this);
            $this->fkArrecadacaoCadastroEconomicoFaturamentos->add($fkArrecadacaoCadastroEconomicoFaturamento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCadastroEconomicoFaturamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento $fkArrecadacaoCadastroEconomicoFaturamento
     */
    public function removeFkArrecadacaoCadastroEconomicoFaturamentos(\Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento $fkArrecadacaoCadastroEconomicoFaturamento)
    {
        $this->fkArrecadacaoCadastroEconomicoFaturamentos->removeElement($fkArrecadacaoCadastroEconomicoFaturamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCadastroEconomicoFaturamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento
     */
    public function getFkArrecadacaoCadastroEconomicoFaturamentos()
    {
        return $this->fkArrecadacaoCadastroEconomicoFaturamentos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDocumentoEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa $fkArrecadacaoDocumentoEmpresa
     * @return CadastroEconomico
     */
    public function addFkArrecadacaoDocumentoEmpresas(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa $fkArrecadacaoDocumentoEmpresa)
    {
        if (false === $this->fkArrecadacaoDocumentoEmpresas->contains($fkArrecadacaoDocumentoEmpresa)) {
            $fkArrecadacaoDocumentoEmpresa->setFkEconomicoCadastroEconomico($this);
            $this->fkArrecadacaoDocumentoEmpresas->add($fkArrecadacaoDocumentoEmpresa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDocumentoEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa $fkArrecadacaoDocumentoEmpresa
     */
    public function removeFkArrecadacaoDocumentoEmpresas(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa $fkArrecadacaoDocumentoEmpresa)
    {
        $this->fkArrecadacaoDocumentoEmpresas->removeElement($fkArrecadacaoDocumentoEmpresa);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDocumentoEmpresas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmpresa
     */
    public function getFkArrecadacaoDocumentoEmpresas()
    {
        return $this->fkArrecadacaoDocumentoEmpresas;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDesoneradoCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico $fkArrecadacaoDesoneradoCadEconomico
     * @return CadastroEconomico
     */
    public function addFkArrecadacaoDesoneradoCadEconomicos(\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico $fkArrecadacaoDesoneradoCadEconomico)
    {
        if (false === $this->fkArrecadacaoDesoneradoCadEconomicos->contains($fkArrecadacaoDesoneradoCadEconomico)) {
            $fkArrecadacaoDesoneradoCadEconomico->setFkEconomicoCadastroEconomico($this);
            $this->fkArrecadacaoDesoneradoCadEconomicos->add($fkArrecadacaoDesoneradoCadEconomico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDesoneradoCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico $fkArrecadacaoDesoneradoCadEconomico
     */
    public function removeFkArrecadacaoDesoneradoCadEconomicos(\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico $fkArrecadacaoDesoneradoCadEconomico)
    {
        $this->fkArrecadacaoDesoneradoCadEconomicos->removeElement($fkArrecadacaoDesoneradoCadEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDesoneradoCadEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico
     */
    public function getFkArrecadacaoDesoneradoCadEconomicos()
    {
        return $this->fkArrecadacaoDesoneradoCadEconomicos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoTomadorEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TomadorEmpresa $fkArrecadacaoTomadorEmpresa
     * @return CadastroEconomico
     */
    public function addFkArrecadacaoTomadorEmpresas(\Urbem\CoreBundle\Entity\Arrecadacao\TomadorEmpresa $fkArrecadacaoTomadorEmpresa)
    {
        if (false === $this->fkArrecadacaoTomadorEmpresas->contains($fkArrecadacaoTomadorEmpresa)) {
            $fkArrecadacaoTomadorEmpresa->setFkEconomicoCadastroEconomico($this);
            $this->fkArrecadacaoTomadorEmpresas->add($fkArrecadacaoTomadorEmpresa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoTomadorEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TomadorEmpresa $fkArrecadacaoTomadorEmpresa
     */
    public function removeFkArrecadacaoTomadorEmpresas(\Urbem\CoreBundle\Entity\Arrecadacao\TomadorEmpresa $fkArrecadacaoTomadorEmpresa)
    {
        $this->fkArrecadacaoTomadorEmpresas->removeElement($fkArrecadacaoTomadorEmpresa);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoTomadorEmpresas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\TomadorEmpresa
     */
    public function getFkArrecadacaoTomadorEmpresas()
    {
        return $this->fkArrecadacaoTomadorEmpresas;
    }

    /**
     * OneToMany (owning side)
     * Add DividaDividaEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaEmpresa $fkDividaDividaEmpresa
     * @return CadastroEconomico
     */
    public function addFkDividaDividaEmpresas(\Urbem\CoreBundle\Entity\Divida\DividaEmpresa $fkDividaDividaEmpresa)
    {
        if (false === $this->fkDividaDividaEmpresas->contains($fkDividaDividaEmpresa)) {
            $fkDividaDividaEmpresa->setFkEconomicoCadastroEconomico($this);
            $this->fkDividaDividaEmpresas->add($fkDividaDividaEmpresa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaDividaEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaEmpresa $fkDividaDividaEmpresa
     */
    public function removeFkDividaDividaEmpresas(\Urbem\CoreBundle\Entity\Divida\DividaEmpresa $fkDividaDividaEmpresa)
    {
        $this->fkDividaDividaEmpresas->removeElement($fkDividaDividaEmpresa);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaDividaEmpresas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\DividaEmpresa
     */
    public function getFkDividaDividaEmpresas()
    {
        return $this->fkDividaDividaEmpresas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtividadeCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico
     * @return CadastroEconomico
     */
    public function addFkEconomicoAtividadeCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico)
    {
        if (false === $this->fkEconomicoAtividadeCadastroEconomicos->contains($fkEconomicoAtividadeCadastroEconomico)) {
            $fkEconomicoAtividadeCadastroEconomico->setFkEconomicoCadastroEconomico($this);
            $this->fkEconomicoAtividadeCadastroEconomicos->add($fkEconomicoAtividadeCadastroEconomico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtividadeCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico
     */
    public function removeFkEconomicoAtividadeCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico $fkEconomicoAtividadeCadastroEconomico)
    {
        $this->fkEconomicoAtividadeCadastroEconomicos->removeElement($fkEconomicoAtividadeCadastroEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtividadeCadastroEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico
     */
    public function getFkEconomicoAtividadeCadastroEconomicos()
    {
        return $this->fkEconomicoAtividadeCadastroEconomicos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoDomicilioFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DomicilioFiscal $fkEconomicoDomicilioFiscal
     * @return CadastroEconomico
     */
    public function addFkEconomicoDomicilioFiscais(\Urbem\CoreBundle\Entity\Economico\DomicilioFiscal $fkEconomicoDomicilioFiscal)
    {
        if (false === $this->fkEconomicoDomicilioFiscais->contains($fkEconomicoDomicilioFiscal)) {
            $fkEconomicoDomicilioFiscal->setFkEconomicoCadastroEconomico($this);
            $this->fkEconomicoDomicilioFiscais->add($fkEconomicoDomicilioFiscal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoDomicilioFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DomicilioFiscal $fkEconomicoDomicilioFiscal
     */
    public function removeFkEconomicoDomicilioFiscais(\Urbem\CoreBundle\Entity\Economico\DomicilioFiscal $fkEconomicoDomicilioFiscal)
    {
        $this->fkEconomicoDomicilioFiscais->removeElement($fkEconomicoDomicilioFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoDomicilioFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DomicilioFiscal
     */
    public function getFkEconomicoDomicilioFiscais()
    {
        return $this->fkEconomicoDomicilioFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadastroEconRespContabil
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil $fkEconomicoCadastroEconRespContabil
     * @return CadastroEconomico
     */
    public function addFkEconomicoCadastroEconRespContabiis(\Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil $fkEconomicoCadastroEconRespContabil)
    {
        if (false === $this->fkEconomicoCadastroEconRespContabiis->contains($fkEconomicoCadastroEconRespContabil)) {
            $fkEconomicoCadastroEconRespContabil->setFkEconomicoCadastroEconomico($this);
            $this->fkEconomicoCadastroEconRespContabiis->add($fkEconomicoCadastroEconRespContabil);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadastroEconRespContabil
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil $fkEconomicoCadastroEconRespContabil
     */
    public function removeFkEconomicoCadastroEconRespContabiis(\Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil $fkEconomicoCadastroEconRespContabil)
    {
        $this->fkEconomicoCadastroEconRespContabiis->removeElement($fkEconomicoCadastroEconRespContabil);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadastroEconRespContabiis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconRespContabil
     */
    public function getFkEconomicoCadastroEconRespContabiis()
    {
        return $this->fkEconomicoCadastroEconRespContabiis;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCadastroEconRespTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico $fkEconomicoCadastroEconRespTecnico
     * @return CadastroEconomico
     */
    public function addFkEconomicoCadastroEconRespTecnicos(\Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico $fkEconomicoCadastroEconRespTecnico)
    {
        if (false === $this->fkEconomicoCadastroEconRespTecnicos->contains($fkEconomicoCadastroEconRespTecnico)) {
            $fkEconomicoCadastroEconRespTecnico->setFkEconomicoCadastroEconomico($this);
            $this->fkEconomicoCadastroEconRespTecnicos->add($fkEconomicoCadastroEconRespTecnico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCadastroEconRespTecnico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico $fkEconomicoCadastroEconRespTecnico
     */
    public function removeFkEconomicoCadastroEconRespTecnicos(\Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico $fkEconomicoCadastroEconRespTecnico)
    {
        $this->fkEconomicoCadastroEconRespTecnicos->removeElement($fkEconomicoCadastroEconRespTecnico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCadastroEconRespTecnicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico
     */
    public function getFkEconomicoCadastroEconRespTecnicos()
    {
        return $this->fkEconomicoCadastroEconRespTecnicos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoDomicilioInformado
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DomicilioInformado $fkEconomicoDomicilioInformado
     * @return CadastroEconomico
     */
    public function addFkEconomicoDomicilioInformados(\Urbem\CoreBundle\Entity\Economico\DomicilioInformado $fkEconomicoDomicilioInformado)
    {
        if (false === $this->fkEconomicoDomicilioInformados->contains($fkEconomicoDomicilioInformado)) {
            $fkEconomicoDomicilioInformado->setFkEconomicoCadastroEconomico($this);
            $this->fkEconomicoDomicilioInformados->add($fkEconomicoDomicilioInformado);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoDomicilioInformado
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DomicilioInformado $fkEconomicoDomicilioInformado
     */
    public function removeFkEconomicoDomicilioInformados(\Urbem\CoreBundle\Entity\Economico\DomicilioInformado $fkEconomicoDomicilioInformado)
    {
        $this->fkEconomicoDomicilioInformados->removeElement($fkEconomicoDomicilioInformado);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoDomicilioInformados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DomicilioInformado
     */
    public function getFkEconomicoDomicilioInformados()
    {
        return $this->fkEconomicoDomicilioInformados;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoDiasCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico $fkEconomicoDiasCadastroEconomico
     * @return CadastroEconomico
     */
    public function addFkEconomicoDiasCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico $fkEconomicoDiasCadastroEconomico)
    {
        if (false === $this->fkEconomicoDiasCadastroEconomicos->contains($fkEconomicoDiasCadastroEconomico)) {
            $fkEconomicoDiasCadastroEconomico->setFkEconomicoCadastroEconomico($this);
            $this->fkEconomicoDiasCadastroEconomicos->add($fkEconomicoDiasCadastroEconomico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoDiasCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico $fkEconomicoDiasCadastroEconomico
     */
    public function removeFkEconomicoDiasCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico $fkEconomicoDiasCadastroEconomico)
    {
        $this->fkEconomicoDiasCadastroEconomicos->removeElement($fkEconomicoDiasCadastroEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoDiasCadastroEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico
     */
    public function getFkEconomicoDiasCadastroEconomicos()
    {
        return $this->fkEconomicoDiasCadastroEconomicos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoBaixaCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico $fkEconomicoBaixaCadastroEconomico
     * @return CadastroEconomico
     */
    public function addFkEconomicoBaixaCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico $fkEconomicoBaixaCadastroEconomico)
    {
        if (false === $this->fkEconomicoBaixaCadastroEconomicos->contains($fkEconomicoBaixaCadastroEconomico)) {
            $fkEconomicoBaixaCadastroEconomico->setFkEconomicoCadastroEconomico($this);
            $this->fkEconomicoBaixaCadastroEconomicos->add($fkEconomicoBaixaCadastroEconomico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoBaixaCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico $fkEconomicoBaixaCadastroEconomico
     */
    public function removeFkEconomicoBaixaCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico $fkEconomicoBaixaCadastroEconomico)
    {
        $this->fkEconomicoBaixaCadastroEconomicos->removeElement($fkEconomicoBaixaCadastroEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoBaixaCadastroEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico
     */
    public function getFkEconomicoBaixaCadastroEconomicos()
    {
        return $this->fkEconomicoBaixaCadastroEconomicos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico $fkEconomicoProcessoCadastroEconomico
     * @return CadastroEconomico
     */
    public function addFkEconomicoProcessoCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico $fkEconomicoProcessoCadastroEconomico)
    {
        if (false === $this->fkEconomicoProcessoCadastroEconomicos->contains($fkEconomicoProcessoCadastroEconomico)) {
            $fkEconomicoProcessoCadastroEconomico->setFkEconomicoCadastroEconomico($this);
            $this->fkEconomicoProcessoCadastroEconomicos->add($fkEconomicoProcessoCadastroEconomico);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico $fkEconomicoProcessoCadastroEconomico
     */
    public function removeFkEconomicoProcessoCadastroEconomicos(\Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico $fkEconomicoProcessoCadastroEconomico)
    {
        $this->fkEconomicoProcessoCadastroEconomicos->removeElement($fkEconomicoProcessoCadastroEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoCadastroEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoCadastroEconomico
     */
    public function getFkEconomicoProcessoCadastroEconomicos()
    {
        return $this->fkEconomicoProcessoCadastroEconomicos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoUsoSoloEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\UsoSoloEmpresa $fkEconomicoUsoSoloEmpresa
     * @return CadastroEconomico
     */
    public function addFkEconomicoUsoSoloEmpresas(\Urbem\CoreBundle\Entity\Economico\UsoSoloEmpresa $fkEconomicoUsoSoloEmpresa)
    {
        if (false === $this->fkEconomicoUsoSoloEmpresas->contains($fkEconomicoUsoSoloEmpresa)) {
            $fkEconomicoUsoSoloEmpresa->setFkEconomicoCadastroEconomico($this);
            $this->fkEconomicoUsoSoloEmpresas->add($fkEconomicoUsoSoloEmpresa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoUsoSoloEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Economico\UsoSoloEmpresa $fkEconomicoUsoSoloEmpresa
     */
    public function removeFkEconomicoUsoSoloEmpresas(\Urbem\CoreBundle\Entity\Economico\UsoSoloEmpresa $fkEconomicoUsoSoloEmpresa)
    {
        $this->fkEconomicoUsoSoloEmpresas->removeElement($fkEconomicoUsoSoloEmpresa);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoUsoSoloEmpresas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\UsoSoloEmpresa
     */
    public function getFkEconomicoUsoSoloEmpresas()
    {
        return $this->fkEconomicoUsoSoloEmpresas;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoAtividadeCadEcon
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon $fkEconomicoProcessoAtividadeCadEcon
     * @return CadastroEconomico
     */
    public function addFkEconomicoProcessoAtividadeCadEcons(\Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon $fkEconomicoProcessoAtividadeCadEcon)
    {
        if (false === $this->fkEconomicoProcessoAtividadeCadEcons->contains($fkEconomicoProcessoAtividadeCadEcon)) {
            $fkEconomicoProcessoAtividadeCadEcon->setFkEconomicoCadastroEconomico($this);
            $this->fkEconomicoProcessoAtividadeCadEcons->add($fkEconomicoProcessoAtividadeCadEcon);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoAtividadeCadEcon
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon $fkEconomicoProcessoAtividadeCadEcon
     */
    public function removeFkEconomicoProcessoAtividadeCadEcons(\Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon $fkEconomicoProcessoAtividadeCadEcon)
    {
        $this->fkEconomicoProcessoAtividadeCadEcons->removeElement($fkEconomicoProcessoAtividadeCadEcon);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoAtividadeCadEcons
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon
     */
    public function getFkEconomicoProcessoAtividadeCadEcons()
    {
        return $this->fkEconomicoProcessoAtividadeCadEcons;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoAutorizacaoNotas
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas
     * @return CadastroEconomico
     */
    public function addFkFiscalizacaoAutorizacaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas)
    {
        if (false === $this->fkFiscalizacaoAutorizacaoNotas->contains($fkFiscalizacaoAutorizacaoNotas)) {
            $fkFiscalizacaoAutorizacaoNotas->setFkEconomicoCadastroEconomico($this);
            $this->fkFiscalizacaoAutorizacaoNotas->add($fkFiscalizacaoAutorizacaoNotas);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutorizacaoNotas
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas
     */
    public function removeFkFiscalizacaoAutorizacaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas $fkFiscalizacaoAutorizacaoNotas)
    {
        $this->fkFiscalizacaoAutorizacaoNotas->removeElement($fkFiscalizacaoAutorizacaoNotas);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutorizacaoNotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutorizacaoNotas
     */
    public function getFkFiscalizacaoAutorizacaoNotas()
    {
        return $this->fkFiscalizacaoAutorizacaoNotas;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoAutenticacaoLivro
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoLivro $fkFiscalizacaoAutenticacaoLivro
     * @return CadastroEconomico
     */
    public function addFkFiscalizacaoAutenticacaoLivros(\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoLivro $fkFiscalizacaoAutenticacaoLivro)
    {
        if (false === $this->fkFiscalizacaoAutenticacaoLivros->contains($fkFiscalizacaoAutenticacaoLivro)) {
            $fkFiscalizacaoAutenticacaoLivro->setFkEconomicoCadastroEconomico($this);
            $this->fkFiscalizacaoAutenticacaoLivros->add($fkFiscalizacaoAutenticacaoLivro);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutenticacaoLivro
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoLivro $fkFiscalizacaoAutenticacaoLivro
     */
    public function removeFkFiscalizacaoAutenticacaoLivros(\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoLivro $fkFiscalizacaoAutenticacaoLivro)
    {
        $this->fkFiscalizacaoAutenticacaoLivros->removeElement($fkFiscalizacaoAutenticacaoLivro);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutenticacaoLivros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoLivro
     */
    public function getFkFiscalizacaoAutenticacaoLivros()
    {
        return $this->fkFiscalizacaoAutenticacaoLivros;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoProcessoFiscalEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa $fkFiscalizacaoProcessoFiscalEmpresa
     * @return CadastroEconomico
     */
    public function addFkFiscalizacaoProcessoFiscalEmpresas(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa $fkFiscalizacaoProcessoFiscalEmpresa)
    {
        if (false === $this->fkFiscalizacaoProcessoFiscalEmpresas->contains($fkFiscalizacaoProcessoFiscalEmpresa)) {
            $fkFiscalizacaoProcessoFiscalEmpresa->setFkEconomicoCadastroEconomico($this);
            $this->fkFiscalizacaoProcessoFiscalEmpresas->add($fkFiscalizacaoProcessoFiscalEmpresa);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoFiscalEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa $fkFiscalizacaoProcessoFiscalEmpresa
     */
    public function removeFkFiscalizacaoProcessoFiscalEmpresas(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa $fkFiscalizacaoProcessoFiscalEmpresa)
    {
        $this->fkFiscalizacaoProcessoFiscalEmpresas->removeElement($fkFiscalizacaoProcessoFiscalEmpresa);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoFiscalEmpresas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa
     */
    public function getFkFiscalizacaoProcessoFiscalEmpresas()
    {
        return $this->fkFiscalizacaoProcessoFiscalEmpresas;
    }

    /**
     * OneToOne (inverse side)
     * Set EconomicoCadastroEconomicoAutonomo
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo $fkEconomicoCadastroEconomicoAutonomo
     * @return CadastroEconomico
     */
    public function setFkEconomicoCadastroEconomicoAutonomo(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo $fkEconomicoCadastroEconomicoAutonomo)
    {
        $fkEconomicoCadastroEconomicoAutonomo->setFkEconomicoCadastroEconomico($this);
        $this->fkEconomicoCadastroEconomicoAutonomo = $fkEconomicoCadastroEconomicoAutonomo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoCadastroEconomicoAutonomo
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo
     */
    public function getFkEconomicoCadastroEconomicoAutonomo()
    {
        return $this->fkEconomicoCadastroEconomicoAutonomo;
    }

    /**
     * OneToOne (inverse side)
     * Set EconomicoCadastroEconomicoEmpresaFato
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato $fkEconomicoCadastroEconomicoEmpresaFato
     * @return CadastroEconomico
     */
    public function setFkEconomicoCadastroEconomicoEmpresaFato(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato $fkEconomicoCadastroEconomicoEmpresaFato)
    {
        $fkEconomicoCadastroEconomicoEmpresaFato->setFkEconomicoCadastroEconomico($this);
        $this->fkEconomicoCadastroEconomicoEmpresaFato = $fkEconomicoCadastroEconomicoEmpresaFato;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoCadastroEconomicoEmpresaFato
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato
     */
    public function getFkEconomicoCadastroEconomicoEmpresaFato()
    {
        return $this->fkEconomicoCadastroEconomicoEmpresaFato;
    }

    /**
     * OneToOne (inverse side)
     * Set EconomicoCadastroEconomicoEmpresaDireito
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito
     * @return CadastroEconomico
     */
    public function setFkEconomicoCadastroEconomicoEmpresaDireito(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito)
    {
        $fkEconomicoCadastroEconomicoEmpresaDireito->setFkEconomicoCadastroEconomico($this);
        $this->fkEconomicoCadastroEconomicoEmpresaDireito = $fkEconomicoCadastroEconomicoEmpresaDireito;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEconomicoCadastroEconomicoEmpresaDireito
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito
     */
    public function getFkEconomicoCadastroEconomicoEmpresaDireito()
    {
        return $this->fkEconomicoCadastroEconomicoEmpresaDireito;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        $cgm = null;
        if ($empresaFato = $this->getFkEconomicoCadastroEconomicoEmpresaFato()) {
            $cgm = $empresaFato->getFkSwCgmPessoaFisica()->getFkSwCgm();
        }

        if ($autonomo = $this->getFkEconomicoCadastroEconomicoAutonomo()) {
            $cgm = $autonomo->getFkSwCgmPessoaFisica()->getFkSwCgm();
        }

        if ($empresaDireito = $this->getFkEconomicoCadastroEconomicoEmpresaDireito()) {
            $cgm = $empresaDireito->getFkSwCgmPessoaJuridica()->getFkSwCgm();
        }

        return (string) sprintf('%s - %s', $this->inscricaoEconomica, (string) $cgm);
    }
}
