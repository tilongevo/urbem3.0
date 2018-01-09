<?php
 
namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * Agencia
 */
class Agencia
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
     * @var string
     */
    private $numAgencia;

    /**
     * @var string
     */
    private $nomAgencia;

    /**
     * @var integer
     */
    private $numcgmAgencia;

    /**
     * @var string
     */
    private $nomPessoaContato;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cgm\Conta
     */
    private $fkCgmContas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\FornecedorConta
     */
    private $fkComprasFornecedorContas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta
     */
    private $fkEstagioEstagiarioEstagioContas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario
     */
    private $fkPessoalContratoPensionistaContaSalarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaFgts
     */
    private $fkPessoalContratoServidorContaFgts;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalarioHistorico
     */
    private $fkPessoalContratoServidorContaSalarioHistoricos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\PensaoBanco
     */
    private $fkPessoalPensaoBancos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia
     */
    private $fkTesourariaTransacoesTransferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento
     */
    private $fkTesourariaTransacoesPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    private $fkMonetarioContaCorrentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    private $fkArrecadacaoLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual
     */
    private $fkArrecadacaoPagamentoLoteManuais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalario
     */
    private $fkPessoalContratoServidorContaSalarios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Banco
     */
    private $fkMonetarioBanco;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCgmContas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasFornecedorContas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEstagioEstagiarioEstagioContas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoPensionistaContaSalarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorContaFgts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorContaSalarioHistoricos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalPensaoBancos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransacoesTransferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransacoesPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioContaCorrentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPagamentoLoteManuais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorContaSalarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return Agencia
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
     * @return Agencia
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
     * Set numAgencia
     *
     * @param string $numAgencia
     * @return Agencia
     */
    public function setNumAgencia($numAgencia)
    {
        $this->numAgencia = $numAgencia;
        return $this;
    }

    /**
     * Get numAgencia
     *
     * @return string
     */
    public function getNumAgencia()
    {
        return $this->numAgencia;
    }

    /**
     * Set nomAgencia
     *
     * @param string $nomAgencia
     * @return Agencia
     */
    public function setNomAgencia($nomAgencia)
    {
        $this->nomAgencia = $nomAgencia;
        return $this;
    }

    /**
     * Get nomAgencia
     *
     * @return string
     */
    public function getNomAgencia()
    {
        return $this->nomAgencia;
    }

    /**
     * Set numcgmAgencia
     *
     * @param integer $numcgmAgencia
     * @return Agencia
     */
    public function setNumcgmAgencia($numcgmAgencia)
    {
        $this->numcgmAgencia = $numcgmAgencia;
        return $this;
    }

    /**
     * Get numcgmAgencia
     *
     * @return integer
     */
    public function getNumcgmAgencia()
    {
        return $this->numcgmAgencia;
    }

    /**
     * Set nomPessoaContato
     *
     * @param string $nomPessoaContato
     * @return Agencia
     */
    public function setNomPessoaContato($nomPessoaContato)
    {
        $this->nomPessoaContato = $nomPessoaContato;
        return $this;
    }

    /**
     * Get nomPessoaContato
     *
     * @return string
     */
    public function getNomPessoaContato()
    {
        return $this->nomPessoaContato;
    }

    /**
     * OneToMany (owning side)
     * Add CgmConta
     *
     * @param \Urbem\CoreBundle\Entity\Cgm\Conta $fkCgmConta
     * @return Agencia
     */
    public function addFkCgmContas(\Urbem\CoreBundle\Entity\Cgm\Conta $fkCgmConta)
    {
        if (false === $this->fkCgmContas->contains($fkCgmConta)) {
            $fkCgmConta->setFkMonetarioAgencia($this);
            $this->fkCgmContas->add($fkCgmConta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CgmConta
     *
     * @param \Urbem\CoreBundle\Entity\Cgm\Conta $fkCgmConta
     */
    public function removeFkCgmContas(\Urbem\CoreBundle\Entity\Cgm\Conta $fkCgmConta)
    {
        $this->fkCgmContas->removeElement($fkCgmConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkCgmContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cgm\Conta
     */
    public function getFkCgmContas()
    {
        return $this->fkCgmContas;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasFornecedorConta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\FornecedorConta $fkComprasFornecedorConta
     * @return Agencia
     */
    public function addFkComprasFornecedorContas(\Urbem\CoreBundle\Entity\Compras\FornecedorConta $fkComprasFornecedorConta)
    {
        if (false === $this->fkComprasFornecedorContas->contains($fkComprasFornecedorConta)) {
            $fkComprasFornecedorConta->setFkMonetarioAgencia($this);
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
     * Add EstagioEstagiarioEstagioConta
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta $fkEstagioEstagiarioEstagioConta
     * @return Agencia
     */
    public function addFkEstagioEstagiarioEstagioContas(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta $fkEstagioEstagiarioEstagioConta)
    {
        if (false === $this->fkEstagioEstagiarioEstagioContas->contains($fkEstagioEstagiarioEstagioConta)) {
            $fkEstagioEstagiarioEstagioConta->setFkMonetarioAgencia($this);
            $this->fkEstagioEstagiarioEstagioContas->add($fkEstagioEstagiarioEstagioConta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EstagioEstagiarioEstagioConta
     *
     * @param \Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta $fkEstagioEstagiarioEstagioConta
     */
    public function removeFkEstagioEstagiarioEstagioContas(\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta $fkEstagioEstagiarioEstagioConta)
    {
        $this->fkEstagioEstagiarioEstagioContas->removeElement($fkEstagioEstagiarioEstagioConta);
    }

    /**
     * OneToMany (owning side)
     * Get fkEstagioEstagiarioEstagioContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta
     */
    public function getFkEstagioEstagiarioEstagioContas()
    {
        return $this->fkEstagioEstagiarioEstagioContas;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoPensionistaContaSalario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario $fkPessoalContratoPensionistaContaSalario
     * @return Agencia
     */
    public function addFkPessoalContratoPensionistaContaSalarios(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario $fkPessoalContratoPensionistaContaSalario)
    {
        if (false === $this->fkPessoalContratoPensionistaContaSalarios->contains($fkPessoalContratoPensionistaContaSalario)) {
            $fkPessoalContratoPensionistaContaSalario->setFkMonetarioAgencia($this);
            $this->fkPessoalContratoPensionistaContaSalarios->add($fkPessoalContratoPensionistaContaSalario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoPensionistaContaSalario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario $fkPessoalContratoPensionistaContaSalario
     */
    public function removeFkPessoalContratoPensionistaContaSalarios(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario $fkPessoalContratoPensionistaContaSalario)
    {
        $this->fkPessoalContratoPensionistaContaSalarios->removeElement($fkPessoalContratoPensionistaContaSalario);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoPensionistaContaSalarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario
     */
    public function getFkPessoalContratoPensionistaContaSalarios()
    {
        return $this->fkPessoalContratoPensionistaContaSalarios;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorContaFgts
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaFgts $fkPessoalContratoServidorContaFgts
     * @return Agencia
     */
    public function addFkPessoalContratoServidorContaFgts(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaFgts $fkPessoalContratoServidorContaFgts)
    {
        if (false === $this->fkPessoalContratoServidorContaFgts->contains($fkPessoalContratoServidorContaFgts)) {
            $fkPessoalContratoServidorContaFgts->setFkMonetarioAgencia($this);
            $this->fkPessoalContratoServidorContaFgts->add($fkPessoalContratoServidorContaFgts);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorContaFgts
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaFgts $fkPessoalContratoServidorContaFgts
     */
    public function removeFkPessoalContratoServidorContaFgts(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaFgts $fkPessoalContratoServidorContaFgts)
    {
        $this->fkPessoalContratoServidorContaFgts->removeElement($fkPessoalContratoServidorContaFgts);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorContaFgts
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaFgts
     */
    public function getFkPessoalContratoServidorContaFgts()
    {
        return $this->fkPessoalContratoServidorContaFgts;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorContaSalarioHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalarioHistorico $fkPessoalContratoServidorContaSalarioHistorico
     * @return Agencia
     */
    public function addFkPessoalContratoServidorContaSalarioHistoricos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalarioHistorico $fkPessoalContratoServidorContaSalarioHistorico)
    {
        if (false === $this->fkPessoalContratoServidorContaSalarioHistoricos->contains($fkPessoalContratoServidorContaSalarioHistorico)) {
            $fkPessoalContratoServidorContaSalarioHistorico->setFkMonetarioAgencia($this);
            $this->fkPessoalContratoServidorContaSalarioHistoricos->add($fkPessoalContratoServidorContaSalarioHistorico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorContaSalarioHistorico
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalarioHistorico $fkPessoalContratoServidorContaSalarioHistorico
     */
    public function removeFkPessoalContratoServidorContaSalarioHistoricos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalarioHistorico $fkPessoalContratoServidorContaSalarioHistorico)
    {
        $this->fkPessoalContratoServidorContaSalarioHistoricos->removeElement($fkPessoalContratoServidorContaSalarioHistorico);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorContaSalarioHistoricos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalarioHistorico
     */
    public function getFkPessoalContratoServidorContaSalarioHistoricos()
    {
        return $this->fkPessoalContratoServidorContaSalarioHistoricos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalPensaoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensaoBanco $fkPessoalPensaoBanco
     * @return Agencia
     */
    public function addFkPessoalPensaoBancos(\Urbem\CoreBundle\Entity\Pessoal\PensaoBanco $fkPessoalPensaoBanco)
    {
        if (false === $this->fkPessoalPensaoBancos->contains($fkPessoalPensaoBanco)) {
            $fkPessoalPensaoBanco->setFkMonetarioAgencia($this);
            $this->fkPessoalPensaoBancos->add($fkPessoalPensaoBanco);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalPensaoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensaoBanco $fkPessoalPensaoBanco
     */
    public function removeFkPessoalPensaoBancos(\Urbem\CoreBundle\Entity\Pessoal\PensaoBanco $fkPessoalPensaoBanco)
    {
        $this->fkPessoalPensaoBancos->removeElement($fkPessoalPensaoBanco);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalPensaoBancos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\PensaoBanco
     */
    public function getFkPessoalPensaoBancos()
    {
        return $this->fkPessoalPensaoBancos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransacoesTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia
     * @return Agencia
     */
    public function addFkTesourariaTransacoesTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia)
    {
        if (false === $this->fkTesourariaTransacoesTransferencias->contains($fkTesourariaTransacoesTransferencia)) {
            $fkTesourariaTransacoesTransferencia->setFkMonetarioAgencia($this);
            $this->fkTesourariaTransacoesTransferencias->add($fkTesourariaTransacoesTransferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransacoesTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia
     */
    public function removeFkTesourariaTransacoesTransferencias(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia $fkTesourariaTransacoesTransferencia)
    {
        $this->fkTesourariaTransacoesTransferencias->removeElement($fkTesourariaTransacoesTransferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransacoesTransferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesTransferencia
     */
    public function getFkTesourariaTransacoesTransferencias()
    {
        return $this->fkTesourariaTransacoesTransferencias;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransacoesPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento $fkTesourariaTransacoesPagamento
     * @return Agencia
     */
    public function addFkTesourariaTransacoesPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento $fkTesourariaTransacoesPagamento)
    {
        if (false === $this->fkTesourariaTransacoesPagamentos->contains($fkTesourariaTransacoesPagamento)) {
            $fkTesourariaTransacoesPagamento->setFkMonetarioAgencia($this);
            $this->fkTesourariaTransacoesPagamentos->add($fkTesourariaTransacoesPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaTransacoesPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento $fkTesourariaTransacoesPagamento
     */
    public function removeFkTesourariaTransacoesPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento $fkTesourariaTransacoesPagamento)
    {
        $this->fkTesourariaTransacoesPagamentos->removeElement($fkTesourariaTransacoesPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaTransacoesPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento
     */
    public function getFkTesourariaTransacoesPagamentos()
    {
        return $this->fkTesourariaTransacoesPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     * @return Agencia
     */
    public function addFkMonetarioContaCorrentes(\Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente)
    {
        if (false === $this->fkMonetarioContaCorrentes->contains($fkMonetarioContaCorrente)) {
            $fkMonetarioContaCorrente->setFkMonetarioAgencia($this);
            $this->fkMonetarioContaCorrentes->add($fkMonetarioContaCorrente);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioContaCorrente
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente
     */
    public function removeFkMonetarioContaCorrentes(\Urbem\CoreBundle\Entity\Monetario\ContaCorrente $fkMonetarioContaCorrente)
    {
        $this->fkMonetarioContaCorrentes->removeElement($fkMonetarioContaCorrente);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioContaCorrentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\ContaCorrente
     */
    public function getFkMonetarioContaCorrentes()
    {
        return $this->fkMonetarioContaCorrentes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote
     * @return Agencia
     */
    public function addFkArrecadacaoLotes(\Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote)
    {
        if (false === $this->fkArrecadacaoLotes->contains($fkArrecadacaoLote)) {
            $fkArrecadacaoLote->setFkMonetarioAgencia($this);
            $this->fkArrecadacaoLotes->add($fkArrecadacaoLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote
     */
    public function removeFkArrecadacaoLotes(\Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote)
    {
        $this->fkArrecadacaoLotes->removeElement($fkArrecadacaoLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    public function getFkArrecadacaoLotes()
    {
        return $this->fkArrecadacaoLotes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPagamentoLoteManual
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual $fkArrecadacaoPagamentoLoteManual
     * @return Agencia
     */
    public function addFkArrecadacaoPagamentoLoteManuais(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual $fkArrecadacaoPagamentoLoteManual)
    {
        if (false === $this->fkArrecadacaoPagamentoLoteManuais->contains($fkArrecadacaoPagamentoLoteManual)) {
            $fkArrecadacaoPagamentoLoteManual->setFkMonetarioAgencia($this);
            $this->fkArrecadacaoPagamentoLoteManuais->add($fkArrecadacaoPagamentoLoteManual);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPagamentoLoteManual
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual $fkArrecadacaoPagamentoLoteManual
     */
    public function removeFkArrecadacaoPagamentoLoteManuais(\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual $fkArrecadacaoPagamentoLoteManual)
    {
        $this->fkArrecadacaoPagamentoLoteManuais->removeElement($fkArrecadacaoPagamentoLoteManual);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPagamentoLoteManuais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\PagamentoLoteManual
     */
    public function getFkArrecadacaoPagamentoLoteManuais()
    {
        return $this->fkArrecadacaoPagamentoLoteManuais;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorContaSalario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalario $fkPessoalContratoServidorContaSalario
     * @return Agencia
     */
    public function addFkPessoalContratoServidorContaSalarios(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalario $fkPessoalContratoServidorContaSalario)
    {
        if (false === $this->fkPessoalContratoServidorContaSalarios->contains($fkPessoalContratoServidorContaSalario)) {
            $fkPessoalContratoServidorContaSalario->setFkMonetarioAgencia($this);
            $this->fkPessoalContratoServidorContaSalarios->add($fkPessoalContratoServidorContaSalario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorContaSalario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalario $fkPessoalContratoServidorContaSalario
     */
    public function removeFkPessoalContratoServidorContaSalarios(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalario $fkPessoalContratoServidorContaSalario)
    {
        $this->fkPessoalContratoServidorContaSalarios->removeElement($fkPessoalContratoServidorContaSalario);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorContaSalarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorContaSalario
     */
    public function getFkPessoalContratoServidorContaSalarios()
    {
        return $this->fkPessoalContratoServidorContaSalarios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioBanco
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Banco $fkMonetarioBanco
     * @return Agencia
     */
    public function setFkMonetarioBanco(\Urbem\CoreBundle\Entity\Monetario\Banco $fkMonetarioBanco)
    {
        $this->codBanco = $fkMonetarioBanco->getCodBanco();
        $this->fkMonetarioBanco = $fkMonetarioBanco;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioBanco
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Banco
     */
    public function getFkMonetarioBanco()
    {
        return $this->fkMonetarioBanco;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return Agencia
     */
    public function setFkSwCgmPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $this->numcgmAgencia = $fkSwCgmPessoaJuridica->getNumcgm();
        $this->fkSwCgmPessoaJuridica = $fkSwCgmPessoaJuridica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridica()
    {
        return $this->fkSwCgmPessoaJuridica;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomAgencia;
    }
}
