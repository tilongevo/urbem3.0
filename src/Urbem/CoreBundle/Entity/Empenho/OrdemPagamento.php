<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * OrdemPagamento
 */
class OrdemPagamento
{
    /**
     * PK
     * @var integer
     */
    private $codOrdem;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var \DateTime
     */
    private $dtEmissao;

    /**
     * @var \DateTime
     */
    private $dtVencimento;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var string
     */
    private $tipo = 'M';

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao
     */
    private $fkEmpenhoOrdemPagamentoRetencoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAnulada
     */
    private $fkEmpenhoOrdemPagamentoAnuladas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAssinatura
     */
    private $fkEmpenhoOrdemPagamentoAssinaturas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao
     */
    private $fkEmpenhoPagamentoLiquidacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoReciboExtra
     */
    private $fkEmpenhoOrdemPagamentoReciboExtras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoOrdemPagamento
     */
    private $fkTesourariaChequeEmissaoOrdemPagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento
     */
    private $fkTesourariaTransacoesPagamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoOrdemPagamentoRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoOrdemPagamentoAnuladas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoOrdemPagamentoAssinaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoPagamentoLiquidacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoOrdemPagamentoReciboExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaChequeEmissaoOrdemPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTesourariaTransacoesPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtEmissao = new \DateTime;
    }

    /**
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return OrdemPagamento
     */
    public function setCodOrdem($codOrdem)
    {
        $this->codOrdem = $codOrdem;
        return $this;
    }

    /**
     * Get codOrdem
     *
     * @return integer
     */
    public function getCodOrdem()
    {
        return $this->codOrdem;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return OrdemPagamento
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return OrdemPagamento
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set dtEmissao
     *
     * @param \DateTime $dtEmissao
     * @return OrdemPagamento
     */
    public function setDtEmissao(\DateTime $dtEmissao)
    {
        $this->dtEmissao = $dtEmissao;
        return $this;
    }

    /**
     * Get dtEmissao
     *
     * @return \DateTime
     */
    public function getDtEmissao()
    {
        return $this->dtEmissao;
    }

    /**
     * Set dtVencimento
     *
     * @param \DateTime $dtVencimento
     * @return OrdemPagamento
     */
    public function setDtVencimento(\DateTime $dtVencimento)
    {
        $this->dtVencimento = $dtVencimento;
        return $this;
    }

    /**
     * Get dtVencimento
     *
     * @return \DateTime
     */
    public function getDtVencimento()
    {
        return $this->dtVencimento;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return OrdemPagamento
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return OrdemPagamento
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
     * Add EmpenhoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao
     * @return OrdemPagamento
     */
    public function addFkEmpenhoOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao)
    {
        if (false === $this->fkEmpenhoOrdemPagamentoRetencoes->contains($fkEmpenhoOrdemPagamentoRetencao)) {
            $fkEmpenhoOrdemPagamentoRetencao->setFkEmpenhoOrdemPagamento($this);
            $this->fkEmpenhoOrdemPagamentoRetencoes->add($fkEmpenhoOrdemPagamentoRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoOrdemPagamentoRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao
     */
    public function removeFkEmpenhoOrdemPagamentoRetencoes(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao $fkEmpenhoOrdemPagamentoRetencao)
    {
        $this->fkEmpenhoOrdemPagamentoRetencoes->removeElement($fkEmpenhoOrdemPagamentoRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoOrdemPagamentoRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoRetencao
     */
    public function getFkEmpenhoOrdemPagamentoRetencoes()
    {
        return $this->fkEmpenhoOrdemPagamentoRetencoes;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoOrdemPagamentoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAnulada $fkEmpenhoOrdemPagamentoAnulada
     * @return OrdemPagamento
     */
    public function addFkEmpenhoOrdemPagamentoAnuladas(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAnulada $fkEmpenhoOrdemPagamentoAnulada)
    {
        if (false === $this->fkEmpenhoOrdemPagamentoAnuladas->contains($fkEmpenhoOrdemPagamentoAnulada)) {
            $fkEmpenhoOrdemPagamentoAnulada->setFkEmpenhoOrdemPagamento($this);
            $this->fkEmpenhoOrdemPagamentoAnuladas->add($fkEmpenhoOrdemPagamentoAnulada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoOrdemPagamentoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAnulada $fkEmpenhoOrdemPagamentoAnulada
     */
    public function removeFkEmpenhoOrdemPagamentoAnuladas(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAnulada $fkEmpenhoOrdemPagamentoAnulada)
    {
        $this->fkEmpenhoOrdemPagamentoAnuladas->removeElement($fkEmpenhoOrdemPagamentoAnulada);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoOrdemPagamentoAnuladas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAnulada
     */
    public function getFkEmpenhoOrdemPagamentoAnuladas()
    {
        return $this->fkEmpenhoOrdemPagamentoAnuladas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoOrdemPagamentoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAssinatura $fkEmpenhoOrdemPagamentoAssinatura
     * @return OrdemPagamento
     */
    public function addFkEmpenhoOrdemPagamentoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAssinatura $fkEmpenhoOrdemPagamentoAssinatura)
    {
        if (false === $this->fkEmpenhoOrdemPagamentoAssinaturas->contains($fkEmpenhoOrdemPagamentoAssinatura)) {
            $fkEmpenhoOrdemPagamentoAssinatura->setFkEmpenhoOrdemPagamento($this);
            $this->fkEmpenhoOrdemPagamentoAssinaturas->add($fkEmpenhoOrdemPagamentoAssinatura);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoOrdemPagamentoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAssinatura $fkEmpenhoOrdemPagamentoAssinatura
     */
    public function removeFkEmpenhoOrdemPagamentoAssinaturas(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAssinatura $fkEmpenhoOrdemPagamentoAssinatura)
    {
        $this->fkEmpenhoOrdemPagamentoAssinaturas->removeElement($fkEmpenhoOrdemPagamentoAssinatura);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoOrdemPagamentoAssinaturas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoAssinatura
     */
    public function getFkEmpenhoOrdemPagamentoAssinaturas()
    {
        return $this->fkEmpenhoOrdemPagamentoAssinaturas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoPagamentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao $fkEmpenhoPagamentoLiquidacao
     * @return OrdemPagamento
     */
    public function addFkEmpenhoPagamentoLiquidacoes(\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao $fkEmpenhoPagamentoLiquidacao)
    {
        if (false === $this->fkEmpenhoPagamentoLiquidacoes->contains($fkEmpenhoPagamentoLiquidacao)) {
            $fkEmpenhoPagamentoLiquidacao->setFkEmpenhoOrdemPagamento($this);
            $this->fkEmpenhoPagamentoLiquidacoes->add($fkEmpenhoPagamentoLiquidacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoPagamentoLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao $fkEmpenhoPagamentoLiquidacao
     */
    public function removeFkEmpenhoPagamentoLiquidacoes(\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao $fkEmpenhoPagamentoLiquidacao)
    {
        $this->fkEmpenhoPagamentoLiquidacoes->removeElement($fkEmpenhoPagamentoLiquidacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoPagamentoLiquidacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacao
     */
    public function getFkEmpenhoPagamentoLiquidacoes()
    {
        return $this->fkEmpenhoPagamentoLiquidacoes;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoOrdemPagamentoReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoReciboExtra $fkEmpenhoOrdemPagamentoReciboExtra
     * @return OrdemPagamento
     */
    public function addFkEmpenhoOrdemPagamentoReciboExtras(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoReciboExtra $fkEmpenhoOrdemPagamentoReciboExtra)
    {
        if (false === $this->fkEmpenhoOrdemPagamentoReciboExtras->contains($fkEmpenhoOrdemPagamentoReciboExtra)) {
            $fkEmpenhoOrdemPagamentoReciboExtra->setFkEmpenhoOrdemPagamento($this);
            $this->fkEmpenhoOrdemPagamentoReciboExtras->add($fkEmpenhoOrdemPagamentoReciboExtra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoOrdemPagamentoReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoReciboExtra $fkEmpenhoOrdemPagamentoReciboExtra
     */
    public function removeFkEmpenhoOrdemPagamentoReciboExtras(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoReciboExtra $fkEmpenhoOrdemPagamentoReciboExtra)
    {
        $this->fkEmpenhoOrdemPagamentoReciboExtras->removeElement($fkEmpenhoOrdemPagamentoReciboExtra);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoOrdemPagamentoReciboExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoReciboExtra
     */
    public function getFkEmpenhoOrdemPagamentoReciboExtras()
    {
        return $this->fkEmpenhoOrdemPagamentoReciboExtras;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaChequeEmissaoOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoOrdemPagamento $fkTesourariaChequeEmissaoOrdemPagamento
     * @return OrdemPagamento
     */
    public function addFkTesourariaChequeEmissaoOrdemPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoOrdemPagamento $fkTesourariaChequeEmissaoOrdemPagamento)
    {
        if (false === $this->fkTesourariaChequeEmissaoOrdemPagamentos->contains($fkTesourariaChequeEmissaoOrdemPagamento)) {
            $fkTesourariaChequeEmissaoOrdemPagamento->setFkEmpenhoOrdemPagamento($this);
            $this->fkTesourariaChequeEmissaoOrdemPagamentos->add($fkTesourariaChequeEmissaoOrdemPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TesourariaChequeEmissaoOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoOrdemPagamento $fkTesourariaChequeEmissaoOrdemPagamento
     */
    public function removeFkTesourariaChequeEmissaoOrdemPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoOrdemPagamento $fkTesourariaChequeEmissaoOrdemPagamento)
    {
        $this->fkTesourariaChequeEmissaoOrdemPagamentos->removeElement($fkTesourariaChequeEmissaoOrdemPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTesourariaChequeEmissaoOrdemPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tesouraria\ChequeEmissaoOrdemPagamento
     */
    public function getFkTesourariaChequeEmissaoOrdemPagamentos()
    {
        return $this->fkTesourariaChequeEmissaoOrdemPagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add TesourariaTransacoesPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento $fkTesourariaTransacoesPagamento
     * @return OrdemPagamento
     */
    public function addFkTesourariaTransacoesPagamentos(\Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento $fkTesourariaTransacoesPagamento)
    {
        if (false === $this->fkTesourariaTransacoesPagamentos->contains($fkTesourariaTransacoesPagamento)) {
            $fkTesourariaTransacoesPagamento->setFkEmpenhoOrdemPagamento($this);
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
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return OrdemPagamento
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * @return float
     */
    public function getValorOriginal()
    {
        $valor = 0.00;
        foreach ($this->getFkEmpenhoPagamentoLiquidacoes() as $pagamento) {
            $valor += $pagamento->getVlPagamento();
        }
        return $valor;
    }

    /**
     * @return float
     */
    public function getValor()
    {
        $valor = 0.00;
        foreach ($this->getFkEmpenhoPagamentoLiquidacoes() as $pagamento) {
            $valor += $pagamento->getVlPagamento();
        }
        $vlAnulado = $this->getValorAnulado();
        $valor -= $vlAnulado;
        return $valor;
    }

    /**
     * @return int
     */
    public function hasPagamentoLiquidacoes()
    {
        return $this->getFkEmpenhoPagamentoLiquidacoes()->count();
    }

    /**
     * @return float
     */
    public function getValorAnulado()
    {
        $valorAnulado = 0.00;
        if ($this->getFkEmpenhoOrdemPagamentoAnuladas()->count()) {
            foreach ($this->getFkEmpenhoOrdemPagamentoAnuladas() as $ordemPagamentoAnulada) {
                $ordemPagamentoLiquidacaoAnuladas = $ordemPagamentoAnulada->getFkEmpenhoOrdemPagamentoLiquidacaoAnuladas();
                foreach ($ordemPagamentoLiquidacaoAnuladas as $ordemPagamentoLiquidacaoAnulada) {
                    $valorAnulado += $ordemPagamentoLiquidacaoAnulada->getVlAnulado();
                }
            }
        }
        return $valorAnulado;
    }

    /**
     * @return float
     */
    public function getValorRetencao()
    {
        $valorRetencao = 0.00;
        if ($this->getFkEmpenhoOrdemPagamentoRetencoes()) {
            foreach ($this->getFkEmpenhoOrdemPagamentoRetencoes() as $retencao) {
                $valorRetencao += $retencao->getVlRetencao();
            }
        }
        return $valorRetencao;
    }

    /**
     * @return float
     */
    public function getValorLiquido()
    {
        $valorOriginal = $this->getValorOriginal();
        $valorRetencao = $this->getValorRetencao();
        $valorAnulado = $this->getValorAnulado();
        return $valorOriginal - $valorRetencao - $valorAnulado;
    }

    /**
     * @return string
     */
    public function getCodOrdemComposto()
    {
        return $this->codOrdem . '/' . $this->exercicio;
    }

    /**
     * @return mixed
     */
    public function getCredor()
    {
        $retorno = null;
        if (!$this->getFkEmpenhoPagamentoLiquidacoes()->isEmpty()) {
            $itens = $this->getFkEmpenhoPagamentoLiquidacoes()
                ->current()
                ->getFkEmpenhoNotaLiquidacao()
                ->getFkEmpenhoNotaLiquidacaoItens();

            if (!$itens->isEmpty()) {
                $retorno = $itens->first()->getFkEmpenhoItemPreEmpenho()->getFkEmpenhoPreEmpenho()->getFkSwCgm();
            }
        }
        return $retorno;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        if (!$this->getFkEmpenhoPagamentoLiquidacoes()->count()) {
            $status = 'Incompleta';
        } else {
            $status = 'Paga';
            if ($this->getValor() == 0.00) {
                $status = 'Anulada';
            } else {
                foreach ($this->getFkEmpenhoPagamentoLiquidacoes() as $pagamento) {
                    if (!$pagamento->getFkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas()->count()) {
                        $status = 'A Pagar';
                    }
                }
            }
        }
        return $status;
    }

    /**
     * @return string|null
     */
    public function getDataStatus()
    {
        $data = null;
        if ($this->hasPagamentoLiquidacoes()) {
            foreach ($this->getFkEmpenhoPagamentoLiquidacoes() as $pagamento) {
                if ($pagamento->getFkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas()->count()) {
                    $notaLiquidacaoPaga = $pagamento->getFkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas()->last();
                    $data = $notaLiquidacaoPaga->getTimestamp();
                }
            }
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getEstornado()
    {
        $estornado = 'Não';
        if ($this->hasPagamentoLiquidacoes()) {
            foreach ($this->getFkEmpenhoPagamentoLiquidacoes() as $pagamento) {
                if ($pagamento->getFkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas()->count()) {
                    $notaLiquidacaoPaga = $pagamento->getFkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas()->last();
                    if ($notaLiquidacaoPaga->getFkEmpenhoNotaLiquidacaoPaga()->getFkEmpenhoNotaLiquidacaoPagaAnuladas()->count()) {
                        $estornado = 'Sim';
                    }
                }
            }
        }
        return $estornado;
    }

    /**
     * @return int|string
     */
    public function getCodEntidadeComposto()
    {
        $entidade = $this->fkOrcamentoEntidade->getCodEntidade();
        $entidade .= ' - ' . $this->fkOrcamentoEntidade->getFkSwCgm()->getNomCgm();
        return $entidade;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codOrdem, $this->exercicio);
    }
}
