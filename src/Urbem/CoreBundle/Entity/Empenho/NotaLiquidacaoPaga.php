<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * NotaLiquidacaoPaga
 */
class NotaLiquidacaoPaga
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $vlPago;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAuditoria
     */
    private $fkEmpenhoNotaLiquidacaoPagaAuditoria;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoContaPagadora
     */
    private $fkEmpenhoNotaLiquidacaoContaPagadora;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Pagamento
     */
    private $fkTesourariaPagamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\Pagamento
     */
    private $fkContabilidadePagamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada
     */
    private $fkEmpenhoNotaLiquidacaoPagaAnuladas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacaoNotaLiquidacaoPaga
     */
    private $fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkContabilidadePagamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoNotaLiquidacaoPagaAnuladas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return NotaLiquidacaoPaga
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
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaLiquidacaoPaga
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaLiquidacaoPaga
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return NotaLiquidacaoPaga
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
     * Set vlPago
     *
     * @param integer $vlPago
     * @return NotaLiquidacaoPaga
     */
    public function setVlPago($vlPago)
    {
        $this->vlPago = $vlPago;
        return $this;
    }

    /**
     * Get vlPago
     *
     * @return integer
     */
    public function getVlPago()
    {
        return $this->vlPago;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return NotaLiquidacaoPaga
     */
    public function setObservacao($observacao = null)
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
     * OneToMany (owning side)
     * Add ContabilidadePagamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Pagamento $fkContabilidadePagamento
     * @return NotaLiquidacaoPaga
     */
    public function addFkContabilidadePagamentos(\Urbem\CoreBundle\Entity\Contabilidade\Pagamento $fkContabilidadePagamento)
    {
        if (false === $this->fkContabilidadePagamentos->contains($fkContabilidadePagamento)) {
            $fkContabilidadePagamento->setFkEmpenhoNotaLiquidacaoPaga($this);
            $this->fkContabilidadePagamentos->add($fkContabilidadePagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ContabilidadePagamento
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\Pagamento $fkContabilidadePagamento
     */
    public function removeFkContabilidadePagamentos(\Urbem\CoreBundle\Entity\Contabilidade\Pagamento $fkContabilidadePagamento)
    {
        $this->fkContabilidadePagamentos->removeElement($fkContabilidadePagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkContabilidadePagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Contabilidade\Pagamento
     */
    public function getFkContabilidadePagamentos()
    {
        return $this->fkContabilidadePagamentos;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoNotaLiquidacaoPagaAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada $fkEmpenhoNotaLiquidacaoPagaAnulada
     * @return NotaLiquidacaoPaga
     */
    public function addFkEmpenhoNotaLiquidacaoPagaAnuladas(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada $fkEmpenhoNotaLiquidacaoPagaAnulada)
    {
        if (false === $this->fkEmpenhoNotaLiquidacaoPagaAnuladas->contains($fkEmpenhoNotaLiquidacaoPagaAnulada)) {
            $fkEmpenhoNotaLiquidacaoPagaAnulada->setFkEmpenhoNotaLiquidacaoPaga($this);
            $this->fkEmpenhoNotaLiquidacaoPagaAnuladas->add($fkEmpenhoNotaLiquidacaoPagaAnulada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoNotaLiquidacaoPagaAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada $fkEmpenhoNotaLiquidacaoPagaAnulada
     */
    public function removeFkEmpenhoNotaLiquidacaoPagaAnuladas(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada $fkEmpenhoNotaLiquidacaoPagaAnulada)
    {
        $this->fkEmpenhoNotaLiquidacaoPagaAnuladas->removeElement($fkEmpenhoNotaLiquidacaoPagaAnulada);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoNotaLiquidacaoPagaAnuladas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAnulada
     */
    public function getFkEmpenhoNotaLiquidacaoPagaAnuladas()
    {
        return $this->fkEmpenhoNotaLiquidacaoPagaAnuladas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacaoNotaLiquidacaoPaga $fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga
     * @return NotaLiquidacaoPaga
     */
    public function addFkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas(\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacaoNotaLiquidacaoPaga $fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga)
    {
        if (false === $this->fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas->contains($fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga)) {
            $fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga->setFkEmpenhoNotaLiquidacaoPaga($this);
            $this->fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas->add($fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacaoNotaLiquidacaoPaga $fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga
     */
    public function removeFkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas(\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacaoNotaLiquidacaoPaga $fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga)
    {
        $this->fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas->removeElement($fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacaoNotaLiquidacaoPaga
     */
    public function getFkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas()
    {
        return $this->fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return NotaLiquidacaoPaga
     */
    public function setFkEmpenhoNotaLiquidacao(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        $this->exercicio = $fkEmpenhoNotaLiquidacao->getExercicio();
        $this->codNota = $fkEmpenhoNotaLiquidacao->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacao->getCodEntidade();
        $this->fkEmpenhoNotaLiquidacao = $fkEmpenhoNotaLiquidacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    public function getFkEmpenhoNotaLiquidacao()
    {
        return $this->fkEmpenhoNotaLiquidacao;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoNotaLiquidacaoPagaAuditoria
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAuditoria $fkEmpenhoNotaLiquidacaoPagaAuditoria
     * @return NotaLiquidacaoPaga
     */
    public function setFkEmpenhoNotaLiquidacaoPagaAuditoria(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAuditoria $fkEmpenhoNotaLiquidacaoPagaAuditoria)
    {
        $fkEmpenhoNotaLiquidacaoPagaAuditoria->setFkEmpenhoNotaLiquidacaoPaga($this);
        $this->fkEmpenhoNotaLiquidacaoPagaAuditoria = $fkEmpenhoNotaLiquidacaoPagaAuditoria;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacaoPagaAuditoria
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoPagaAuditoria
     */
    public function getFkEmpenhoNotaLiquidacaoPagaAuditoria()
    {
        return $this->fkEmpenhoNotaLiquidacaoPagaAuditoria;
    }

    /**
     * OneToOne (inverse side)
     * Set EmpenhoNotaLiquidacaoContaPagadora
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoContaPagadora $fkEmpenhoNotaLiquidacaoContaPagadora
     * @return NotaLiquidacaoPaga
     */
    public function setFkEmpenhoNotaLiquidacaoContaPagadora(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoContaPagadora $fkEmpenhoNotaLiquidacaoContaPagadora)
    {
        $fkEmpenhoNotaLiquidacaoContaPagadora->setFkEmpenhoNotaLiquidacaoPaga($this);
        $this->fkEmpenhoNotaLiquidacaoContaPagadora = $fkEmpenhoNotaLiquidacaoContaPagadora;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkEmpenhoNotaLiquidacaoContaPagadora
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoContaPagadora
     */
    public function getFkEmpenhoNotaLiquidacaoContaPagadora()
    {
        return $this->fkEmpenhoNotaLiquidacaoContaPagadora;
    }

    /**
     * OneToOne (inverse side)
     * Set TesourariaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento
     * @return NotaLiquidacaoPaga
     */
    public function setFkTesourariaPagamento(\Urbem\CoreBundle\Entity\Tesouraria\Pagamento $fkTesourariaPagamento)
    {
        $fkTesourariaPagamento->setFkEmpenhoNotaLiquidacaoPaga($this);
        $this->fkTesourariaPagamento = $fkTesourariaPagamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkTesourariaPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Pagamento
     */
    public function getFkTesourariaPagamento()
    {
        return $this->fkTesourariaPagamento;
    }
}
