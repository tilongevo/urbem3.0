<?php

namespace Urbem\CoreBundle\Entity\Compras;

/**
 * Fornecedor
 */
class Fornecedor
{
    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * @var integer
     */
    private $vlMinimoNf;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * @var string
     */
    private $tipo = 'N';

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Beneficio\FornecedorAuxilioRefeicao
     */
    private $fkBeneficioFornecedorAuxilioRefeicao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Beneficio\FornecedorConvenioMedico
     */
    private $fkBeneficioFornecedorConvenioMedico;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Beneficio\FornecedorValeTransporte
     */
    private $fkBeneficioFornecedorValeTransporte;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor
     */
    private $fkBeneficioLayoutFornecedor;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ValeTransporte
     */
    private $fkBeneficioValeTransportes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorClassificacao
     */
    private $fkComprasFornecedorClassificacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorInativacao
     */
    private $fkComprasFornecedorInativacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorAtividade
     */
    private $fkComprasFornecedorAtividades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorConta
     */
    private $fkComprasFornecedorContas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem
     */
    private $fkComprasCotacaoFornecedorItens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Participante
     */
    private $fkLicitacaoParticipantes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante
     */
    private $fkTcemgConvenioParticipantes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    private $fkBeneficioBeneficiarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorSocio
     */
    private $fkComprasFornecedorSocios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor
     */
    private $fkComprasNotaFiscalFornecedores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor
     */
    private $fkTcemgContratoFornecedores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioValeTransportes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasFornecedorClassificacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasFornecedorInativacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasFornecedorAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasFornecedorContas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasCotacaoFornecedorItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoParticipantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgConvenioParticipantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioBeneficiarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasFornecedorSocios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasNotaFiscalFornecedores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgContratoFornecedores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return Fornecedor
     */
    public function setCgmFornecedor($cgmFornecedor)
    {
        $this->cgmFornecedor = $cgmFornecedor;
        return $this;
    }

    /**
     * Get cgmFornecedor
     *
     * @return integer
     */
    public function getCgmFornecedor()
    {
        return $this->cgmFornecedor;
    }

    /**
     * Set vlMinimoNf
     *
     * @param integer $vlMinimoNf
     * @return Fornecedor
     */
    public function setVlMinimoNf($vlMinimoNf = null)
    {
        $this->vlMinimoNf = $vlMinimoNf;
        return $this;
    }

    /**
     * Get vlMinimoNf
     *
     * @return integer
     */
    public function getVlMinimoNf()
    {
        return $this->vlMinimoNf;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Fornecedor
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Fornecedor
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ValeTransporte $fkBeneficioValeTransporte
     * @return Fornecedor
     */
    public function addFkBeneficioValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ValeTransporte $fkBeneficioValeTransporte)
    {
        if (false === $this->fkBeneficioValeTransportes->contains($fkBeneficioValeTransporte)) {
            $fkBeneficioValeTransporte->setFkComprasFornecedor($this);
            $this->fkBeneficioValeTransportes->add($fkBeneficioValeTransporte);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ValeTransporte $fkBeneficioValeTransporte
     */
    public function removeFkBeneficioValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ValeTransporte $fkBeneficioValeTransporte)
    {
        $this->fkBeneficioValeTransportes->removeElement($fkBeneficioValeTransporte);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioValeTransportes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ValeTransporte
     */
    public function getFkBeneficioValeTransportes()
    {
        return $this->fkBeneficioValeTransportes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasFornecedorClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorClassificacao $fkComprasFornecedorClassificacao
     * @return Fornecedor
     */
    public function addFkComprasFornecedorClassificacoes(\Urbem\CoreBundle\Entity\Compras\FornecedorClassificacao $fkComprasFornecedorClassificacao)
    {
        if (false === $this->fkComprasFornecedorClassificacoes->contains($fkComprasFornecedorClassificacao)) {
            $fkComprasFornecedorClassificacao->setFkComprasFornecedor($this);
            $this->fkComprasFornecedorClassificacoes->add($fkComprasFornecedorClassificacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasFornecedorClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorClassificacao $fkComprasFornecedorClassificacao
     */
    public function removeFkComprasFornecedorClassificacoes(\Urbem\CoreBundle\Entity\Compras\FornecedorClassificacao $fkComprasFornecedorClassificacao)
    {
        $this->fkComprasFornecedorClassificacoes->removeElement($fkComprasFornecedorClassificacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasFornecedorClassificacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorClassificacao
     */
    public function getFkComprasFornecedorClassificacoes()
    {
        return $this->fkComprasFornecedorClassificacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasFornecedorInativacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorInativacao $fkComprasFornecedorInativacao
     * @return Fornecedor
     */
    public function addFkComprasFornecedorInativacoes(\Urbem\CoreBundle\Entity\Compras\FornecedorInativacao $fkComprasFornecedorInativacao)
    {
        if (false === $this->fkComprasFornecedorInativacoes->contains($fkComprasFornecedorInativacao)) {
            $fkComprasFornecedorInativacao->setFkComprasFornecedor($this);
            $this->fkComprasFornecedorInativacoes->add($fkComprasFornecedorInativacao);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasFornecedorInativacao
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorInativacao $fkComprasFornecedorInativacao
     */
    public function removeFkComprasFornecedorInativacoes(\Urbem\CoreBundle\Entity\Compras\FornecedorInativacao $fkComprasFornecedorInativacao)
    {
        $this->fkComprasFornecedorInativacoes->removeElement($fkComprasFornecedorInativacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasFornecedorInativacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorInativacao
     */
    public function getFkComprasFornecedorInativacoes()
    {
        return $this->fkComprasFornecedorInativacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasFornecedorAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorAtividade $fkComprasFornecedorAtividade
     * @return Fornecedor
     */
    public function addFkComprasFornecedorAtividades(\Urbem\CoreBundle\Entity\Compras\FornecedorAtividade $fkComprasFornecedorAtividade)
    {
        if (false === $this->fkComprasFornecedorAtividades->contains($fkComprasFornecedorAtividade)) {
            $fkComprasFornecedorAtividade->setFkComprasFornecedor($this);
            $this->fkComprasFornecedorAtividades->add($fkComprasFornecedorAtividade);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasFornecedorAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorAtividade $fkComprasFornecedorAtividade
     */
    public function removeFkComprasFornecedorAtividades(\Urbem\CoreBundle\Entity\Compras\FornecedorAtividade $fkComprasFornecedorAtividade)
    {
        $this->fkComprasFornecedorAtividades->removeElement($fkComprasFornecedorAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasFornecedorAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorAtividade
     */
    public function getFkComprasFornecedorAtividades()
    {
        return $this->fkComprasFornecedorAtividades;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasFornecedorConta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorConta $fkComprasFornecedorConta
     * @return Fornecedor
     */
    public function addFkComprasFornecedorContas(\Urbem\CoreBundle\Entity\Compras\FornecedorConta $fkComprasFornecedorConta)
    {
        if (false === $this->fkComprasFornecedorContas->contains($fkComprasFornecedorConta)) {
            $fkComprasFornecedorConta->setFkComprasFornecedor($this);
            $this->fkComprasFornecedorContas->add($fkComprasFornecedorConta);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasFornecedorConta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorConta $fkComprasFornecedorConta
     */
    public function removeFkComprasFornecedorContas(\Urbem\CoreBundle\Entity\Compras\FornecedorConta $fkComprasFornecedorConta)
    {
        $this->fkComprasFornecedorContas->removeElement($fkComprasFornecedorConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasFornecedorContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorConta
     */
    public function getFkComprasFornecedorContas()
    {
        return $this->fkComprasFornecedorContas;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasCotacaoFornecedorItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem
     * @return Fornecedor
     */
    public function addFkComprasCotacaoFornecedorItens(\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem)
    {
        if (false === $this->fkComprasCotacaoFornecedorItens->contains($fkComprasCotacaoFornecedorItem)) {
            $fkComprasCotacaoFornecedorItem->setFkComprasFornecedor($this);
            $this->fkComprasCotacaoFornecedorItens->add($fkComprasCotacaoFornecedorItem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasCotacaoFornecedorItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem
     */
    public function removeFkComprasCotacaoFornecedorItens(\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem $fkComprasCotacaoFornecedorItem)
    {
        $this->fkComprasCotacaoFornecedorItens->removeElement($fkComprasCotacaoFornecedorItem);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasCotacaoFornecedorItens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CotacaoFornecedorItem
     */
    public function getFkComprasCotacaoFornecedorItens()
    {
        return $this->fkComprasCotacaoFornecedorItens;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return Fornecedor
     */
    public function addFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        if (false === $this->fkLicitacaoContratos->contains($fkLicitacaoContrato)) {
            $fkLicitacaoContrato->setFkComprasFornecedor($this);
            $this->fkLicitacaoContratos->add($fkLicitacaoContrato);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     */
    public function removeFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->fkLicitacaoContratos->removeElement($fkLicitacaoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContratos()
    {
        return $this->fkLicitacaoContratos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante
     * @return Fornecedor
     */
    public function addFkLicitacaoParticipantes(\Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante)
    {
        if (false === $this->fkLicitacaoParticipantes->contains($fkLicitacaoParticipante)) {
            $fkLicitacaoParticipante->setFkComprasFornecedor($this);
            $this->fkLicitacaoParticipantes->add($fkLicitacaoParticipante);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante
     */
    public function removeFkLicitacaoParticipantes(\Urbem\CoreBundle\Entity\Licitacao\Participante $fkLicitacaoParticipante)
    {
        $this->fkLicitacaoParticipantes->removeElement($fkLicitacaoParticipante);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipantes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Participante
     */
    public function getFkLicitacaoParticipantes()
    {
        return $this->fkLicitacaoParticipantes;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConvenioParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante $fkTcemgConvenioParticipante
     * @return Fornecedor
     */
    public function addFkTcemgConvenioParticipantes(\Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante $fkTcemgConvenioParticipante)
    {
        if (false === $this->fkTcemgConvenioParticipantes->contains($fkTcemgConvenioParticipante)) {
            $fkTcemgConvenioParticipante->setFkComprasFornecedor($this);
            $this->fkTcemgConvenioParticipantes->add($fkTcemgConvenioParticipante);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConvenioParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante $fkTcemgConvenioParticipante
     */
    public function removeFkTcemgConvenioParticipantes(\Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante $fkTcemgConvenioParticipante)
    {
        $this->fkTcemgConvenioParticipantes->removeElement($fkTcemgConvenioParticipante);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConvenioParticipantes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante
     */
    public function getFkTcemgConvenioParticipantes()
    {
        return $this->fkTcemgConvenioParticipantes;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioBeneficiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario
     * @return Fornecedor
     */
    public function addFkBeneficioBeneficiarios(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        if (false === $this->fkBeneficioBeneficiarios->contains($fkBeneficioBeneficiario)) {
            $fkBeneficioBeneficiario->setFkComprasFornecedor($this);
            $this->fkBeneficioBeneficiarios->add($fkBeneficioBeneficiario);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioBeneficiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario
     */
    public function removeFkBeneficioBeneficiarios(\Urbem\CoreBundle\Entity\Beneficio\Beneficiario $fkBeneficioBeneficiario)
    {
        $this->fkBeneficioBeneficiarios->removeElement($fkBeneficioBeneficiario);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioBeneficiarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\Beneficiario
     */
    public function getFkBeneficioBeneficiarios()
    {
        return $this->fkBeneficioBeneficiarios;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasFornecedorSocio
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorSocio $fkComprasFornecedorSocio
     * @return Fornecedor
     */
    public function addFkComprasFornecedorSocios(\Urbem\CoreBundle\Entity\Compras\FornecedorSocio $fkComprasFornecedorSocio)
    {
        if (false === $this->fkComprasFornecedorSocios->contains($fkComprasFornecedorSocio)) {
            $fkComprasFornecedorSocio->setFkComprasFornecedor($this);
            $this->fkComprasFornecedorSocios->add($fkComprasFornecedorSocio);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasFornecedorSocio
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorSocio $fkComprasFornecedorSocio
     */
    public function removeFkComprasFornecedorSocios(\Urbem\CoreBundle\Entity\Compras\FornecedorSocio $fkComprasFornecedorSocio)
    {
        $this->fkComprasFornecedorSocios->removeElement($fkComprasFornecedorSocio);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasFornecedorSocios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorSocio
     */
    public function getFkComprasFornecedorSocios()
    {
        return $this->fkComprasFornecedorSocios;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasNotaFiscalFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor $fkComprasNotaFiscalFornecedor
     * @return Fornecedor
     */
    public function addFkComprasNotaFiscalFornecedores(\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor $fkComprasNotaFiscalFornecedor)
    {
        if (false === $this->fkComprasNotaFiscalFornecedores->contains($fkComprasNotaFiscalFornecedor)) {
            $fkComprasNotaFiscalFornecedor->setFkComprasFornecedor($this);
            $this->fkComprasNotaFiscalFornecedores->add($fkComprasNotaFiscalFornecedor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasNotaFiscalFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor $fkComprasNotaFiscalFornecedor
     */
    public function removeFkComprasNotaFiscalFornecedores(\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor $fkComprasNotaFiscalFornecedor)
    {
        $this->fkComprasNotaFiscalFornecedores->removeElement($fkComprasNotaFiscalFornecedor);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasNotaFiscalFornecedores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor
     */
    public function getFkComprasNotaFiscalFornecedores()
    {
        return $this->fkComprasNotaFiscalFornecedores;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgContratoFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor $fkTcemgContratoFornecedor
     * @return Fornecedor
     */
    public function addFkTcemgContratoFornecedores(\Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor $fkTcemgContratoFornecedor)
    {
        if (false === $this->fkTcemgContratoFornecedores->contains($fkTcemgContratoFornecedor)) {
            $fkTcemgContratoFornecedor->setFkComprasFornecedor($this);
            $this->fkTcemgContratoFornecedores->add($fkTcemgContratoFornecedor);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgContratoFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor $fkTcemgContratoFornecedor
     */
    public function removeFkTcemgContratoFornecedores(\Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor $fkTcemgContratoFornecedor)
    {
        $this->fkTcemgContratoFornecedores->removeElement($fkTcemgContratoFornecedor);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgContratoFornecedores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor
     */
    public function getFkTcemgContratoFornecedores()
    {
        return $this->fkTcemgContratoFornecedores;
    }

    /**
     * OneToOne (inverse side)
     * Set BeneficioFornecedorAuxilioRefeicao
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\FornecedorAuxilioRefeicao $fkBeneficioFornecedorAuxilioRefeicao
     * @return Fornecedor
     */
    public function setFkBeneficioFornecedorAuxilioRefeicao(\Urbem\CoreBundle\Entity\Beneficio\FornecedorAuxilioRefeicao $fkBeneficioFornecedorAuxilioRefeicao)
    {
        $fkBeneficioFornecedorAuxilioRefeicao->setFkComprasFornecedor($this);
        $this->fkBeneficioFornecedorAuxilioRefeicao = $fkBeneficioFornecedorAuxilioRefeicao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkBeneficioFornecedorAuxilioRefeicao
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\FornecedorAuxilioRefeicao
     */
    public function getFkBeneficioFornecedorAuxilioRefeicao()
    {
        return $this->fkBeneficioFornecedorAuxilioRefeicao;
    }

    /**
     * OneToOne (inverse side)
     * Set BeneficioFornecedorConvenioMedico
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\FornecedorConvenioMedico $fkBeneficioFornecedorConvenioMedico
     * @return Fornecedor
     */
    public function setFkBeneficioFornecedorConvenioMedico(\Urbem\CoreBundle\Entity\Beneficio\FornecedorConvenioMedico $fkBeneficioFornecedorConvenioMedico)
    {
        $fkBeneficioFornecedorConvenioMedico->setFkComprasFornecedor($this);
        $this->fkBeneficioFornecedorConvenioMedico = $fkBeneficioFornecedorConvenioMedico;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkBeneficioFornecedorConvenioMedico
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\FornecedorConvenioMedico
     */
    public function getFkBeneficioFornecedorConvenioMedico()
    {
        return $this->fkBeneficioFornecedorConvenioMedico;
    }

    /**
     * OneToOne (inverse side)
     * Set BeneficioFornecedorValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\FornecedorValeTransporte $fkBeneficioFornecedorValeTransporte
     * @return Fornecedor
     */
    public function setFkBeneficioFornecedorValeTransporte(\Urbem\CoreBundle\Entity\Beneficio\FornecedorValeTransporte $fkBeneficioFornecedorValeTransporte)
    {
        $fkBeneficioFornecedorValeTransporte->setFkComprasFornecedor($this);
        $this->fkBeneficioFornecedorValeTransporte = $fkBeneficioFornecedorValeTransporte;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkBeneficioFornecedorValeTransporte
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\FornecedorValeTransporte
     */
    public function getFkBeneficioFornecedorValeTransporte()
    {
        return $this->fkBeneficioFornecedorValeTransporte;
    }

    /**
     * OneToOne (inverse side)
     * Set BeneficioLayoutFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor $fkBeneficioLayoutFornecedor
     * @return Fornecedor
     */
    public function setFkBeneficioLayoutFornecedor(\Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor $fkBeneficioLayoutFornecedor)
    {
        $fkBeneficioLayoutFornecedor->setFkComprasFornecedor($this);
        $this->fkBeneficioLayoutFornecedor = $fkBeneficioLayoutFornecedor;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkBeneficioLayoutFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor
     */
    public function getFkBeneficioLayoutFornecedor()
    {
        return $this->fkBeneficioLayoutFornecedor;
    }

    /**
     * OneToOne (owning side)
     * Set SwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Fornecedor
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmFornecedor = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkSwCgm;
    }
}
