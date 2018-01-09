<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * PagamentoLiquidacao
 */
class PagamentoLiquidacao
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
     * PK
     * @var string
     */
    private $exercicioLiquidacao;

    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var integer
     */
    private $vlPagamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada
     */
    private $fkEmpenhoOrdemPagamentoLiquidacaoAnuladas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacaoNotaLiquidacaoPaga
     */
    private $fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento
     */
    private $fkEmpenhoOrdemPagamento;

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
        $this->fkEmpenhoOrdemPagamentoLiquidacaoAnuladas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codOrdem
     *
     * @param integer $codOrdem
     * @return PagamentoLiquidacao
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
     * @return PagamentoLiquidacao
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
     * @return PagamentoLiquidacao
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
     * Set exercicioLiquidacao
     *
     * @param string $exercicioLiquidacao
     * @return PagamentoLiquidacao
     */
    public function setExercicioLiquidacao($exercicioLiquidacao)
    {
        $this->exercicioLiquidacao = $exercicioLiquidacao;
        return $this;
    }

    /**
     * Get exercicioLiquidacao
     *
     * @return string
     */
    public function getExercicioLiquidacao()
    {
        return $this->exercicioLiquidacao;
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return PagamentoLiquidacao
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
     * Set vlPagamento
     *
     * @param integer $vlPagamento
     * @return PagamentoLiquidacao
     */
    public function setVlPagamento($vlPagamento = null)
    {
        $this->vlPagamento = $vlPagamento;
        return $this;
    }

    /**
     * Get vlPagamento
     *
     * @return integer
     */
    public function getVlPagamento()
    {
        return $this->vlPagamento;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoOrdemPagamentoLiquidacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada $fkEmpenhoOrdemPagamentoLiquidacaoAnulada
     * @return PagamentoLiquidacao
     */
    public function addFkEmpenhoOrdemPagamentoLiquidacaoAnuladas(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada $fkEmpenhoOrdemPagamentoLiquidacaoAnulada)
    {
        if (false === $this->fkEmpenhoOrdemPagamentoLiquidacaoAnuladas->contains($fkEmpenhoOrdemPagamentoLiquidacaoAnulada)) {
            $fkEmpenhoOrdemPagamentoLiquidacaoAnulada->setFkEmpenhoPagamentoLiquidacao($this);
            $this->fkEmpenhoOrdemPagamentoLiquidacaoAnuladas->add($fkEmpenhoOrdemPagamentoLiquidacaoAnulada);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoOrdemPagamentoLiquidacaoAnulada
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada $fkEmpenhoOrdemPagamentoLiquidacaoAnulada
     */
    public function removeFkEmpenhoOrdemPagamentoLiquidacaoAnuladas(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada $fkEmpenhoOrdemPagamentoLiquidacaoAnulada)
    {
        $this->fkEmpenhoOrdemPagamentoLiquidacaoAnuladas->removeElement($fkEmpenhoOrdemPagamentoLiquidacaoAnulada);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoOrdemPagamentoLiquidacaoAnuladas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\OrdemPagamentoLiquidacaoAnulada
     */
    public function getFkEmpenhoOrdemPagamentoLiquidacaoAnuladas()
    {
        return $this->fkEmpenhoOrdemPagamentoLiquidacaoAnuladas;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacaoNotaLiquidacaoPaga $fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga
     * @return PagamentoLiquidacao
     */
    public function addFkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas(\Urbem\CoreBundle\Entity\Empenho\PagamentoLiquidacaoNotaLiquidacaoPaga $fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga)
    {
        if (false === $this->fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas->contains($fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga)) {
            $fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga->setFkEmpenhoPagamentoLiquidacao($this);
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
     * Set fkEmpenhoOrdemPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento
     * @return PagamentoLiquidacao
     */
    public function setFkEmpenhoOrdemPagamento(\Urbem\CoreBundle\Entity\Empenho\OrdemPagamento $fkEmpenhoOrdemPagamento)
    {
        $this->codOrdem = $fkEmpenhoOrdemPagamento->getCodOrdem();
        $this->exercicio = $fkEmpenhoOrdemPagamento->getExercicio();
        $this->codEntidade = $fkEmpenhoOrdemPagamento->getCodEntidade();
        $this->fkEmpenhoOrdemPagamento = $fkEmpenhoOrdemPagamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoOrdemPagamento
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\OrdemPagamento
     */
    public function getFkEmpenhoOrdemPagamento()
    {
        return $this->fkEmpenhoOrdemPagamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return PagamentoLiquidacao
     */
    public function setFkEmpenhoNotaLiquidacao(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        $this->exercicioLiquidacao = $fkEmpenhoNotaLiquidacao->getExercicio();
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
     * @return int
     */
    public function getVlLiquido()
    {
        $valor = $this->vlPagamento;
        foreach ($this->fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas as $fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga) {
            $notaLiquidacaoPaga = $fkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPaga->getFkEmpenhoNotaLiquidacaoPaga();
            $valor -= $notaLiquidacaoPaga->getVlPago();
            foreach ($notaLiquidacaoPaga->getFkEmpenhoNotaLiquidacaoPagaAnuladas() as $fkEmpenhoNotaLiquidacaoPagaAnulada) {
                $valor += $fkEmpenhoNotaLiquidacaoPagaAnulada->getVlAnulado();
            }
        }
        return $valor;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->codNota, $this->exercicioLiquidacao);
    }
}
